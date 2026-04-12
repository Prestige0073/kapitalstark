<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LoanRequest;
use App\Models\Loan;
use App\Models\Appointment;
use App\Models\Message;
use App\Models\ContactRequest;
use App\Models\AppointmentRequest;
use App\Models\Document;
use App\Models\Transfer;
use App\Models\AdminTemplateDocument;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Mail\LoanRequestStatusChanged;
use App\Mail\AdvisorMessage;
use App\Services\PushService;
use App\Services\PdfService;

class AdminController extends Controller
{
    /* ── Dashboard ──────────────────────────────────────────── */
    public function index()
    {
        return view('admin.index', [
            'stats' => [
                'users'             => User::count(),
                'pending'           => LoanRequest::where('status', 'pending')->count(),
                'active_requests'   => LoanRequest::whereIn('status', LoanRequest::ACTIVE_STATUSES)->count(),
                'docs_to_review'    => LoanRequest::whereIn('status', ['documents_submitted','under_review'])->count(),
                'to_approve'        => LoanRequest::whereIn('status', ['validated','confirmed'])->count(),
                'loans'             => Loan::where('status', 'active')->count(),
                'messages'          => Message::where('read', false)->where('direction', 'inbound')->count(),
                'appointments'      => Appointment::where('status', 'upcoming')->count(),
                'contacts'          => ContactRequest::where('handled', false)->count(),
                'rdv_requests'      => AppointmentRequest::where('handled', false)->count(),
            ],
            'recent_requests' => LoanRequest::with('user')->latest()->limit(8)->get(),
            'recent_users'    => User::latest()->limit(6)->get(),
        ]);
    }

    /* ── Demandes de prêt ───────────────────────────────────── */
    public function requests(Request $request)
    {
        $q = LoanRequest::with('user')->latest();

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $q->whereHas('user', fn ($u) => $u->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%'));
        }

        $allStatuses = [
            'pending', 'analysis', 'contract_sent', 'documents_submitted',
            'under_review', 'offer', 'validated', 'confirmed',
            'approved', 'signed', 'rejected',
        ];

        return view('admin.requests', [
            'requests'   => $q->paginate(15)->withQueryString(),
            'statuses'   => $allStatuses,
            'allStatuses'=> $allStatuses,
        ]);
    }

    public function showRequest(int $id)
    {
        $lr = LoanRequest::with(['user', 'documents'])->findOrFail($id);
        return view('admin.request-show', compact('lr'));
    }

    public function updateRequestStatus(Request $request, int $id)
    {
        $valid = ['pending','contract_sent','documents_submitted','under_review','validated','confirmed','approved','rejected','analysis','offer','signed'];
        $request->validate(['status' => 'required|in:'.implode(',', $valid)]);

        $lr = LoanRequest::with('user')->findOrFail($id);
        $lr->update(['status' => $request->status, 'reviewed_at' => now()]);

        return back()->with('success', 'Statut mis à jour.');
    }

    /* ── Envoyer le contrat à signer ────────────────────────── */
    public function sendContract(Request $request, int $id)
    {
        $request->validate([
            'contract' => 'required|file|mimes:pdf|max:20480',
            'notes'    => 'nullable|string|max:1000',
        ], [
            'contract.required' => 'Veuillez joindre le contrat PDF.',
            'contract.mimes'    => 'Le contrat doit être au format PDF.',
        ]);

        $lr = LoanRequest::with('user')->findOrFail($id);

        if (!in_array($lr->status, ['pending', 'contract_sent'])) {
            return back()->with('error', 'Impossible d\'envoyer un contrat pour ce statut.');
        }

        $path = $request->file('contract')->storeAs(
            'contracts/' . $lr->id,
            'contrat-' . now()->format('Ymd-His') . '.pdf',
            'local'
        );

        $lr->update([
            'status'        => 'contract_sent',
            'contract_path' => $path,
            'admin_notes'   => $request->notes ?: $lr->admin_notes,
            'reviewed_at'   => now(),
        ]);

        Mail::to($lr->user->email)->queue(new LoanRequestStatusChanged($lr));

        return back()->with('success', 'Contrat envoyé au client. Il peut maintenant le télécharger et le signer.');
    }

    /* ── Valider le dossier (après soumission des documents) ─── */
    public function validateDossier(Request $request, int $id)
    {
        $request->validate(['notes' => 'nullable|string|max:1000']);

        $lr = LoanRequest::with('user')->findOrFail($id);

        if (!in_array($lr->status, ['documents_submitted', 'under_review'])) {
            return back()->with('error', 'Le dossier doit avoir des documents soumis pour être validé.');
        }

        $lr->update([
            'status'      => 'validated',
            'admin_notes' => $request->notes ?: $lr->admin_notes,
            'reviewed_at' => now(),
        ]);

        Mail::to($lr->user->email)->queue(new LoanRequestStatusChanged($lr));

        return back()->with('success', 'Dossier validé. Le client peut maintenant confirmer sa demande de prêt.');
    }

    /* ── Approuver le prêt et créditer le compte ─────────────── */
    public function approveLoan(Request $request, int $id)
    {
        $request->validate([
            'approved_amount' => 'required|numeric|min:1',
            'notes'           => 'nullable|string|max:1000',
        ]);

        $lr = LoanRequest::with('user')->findOrFail($id);

        if (!in_array($lr->status, ['confirmed', 'validated'])) {
            return back()->with('error', 'La demande doit être confirmée par le client avant approbation.');
        }

        $amount = (float) $request->approved_amount;

        // 1. Mettre à jour la demande
        $lr->update([
            'status'          => 'approved',
            'approved_amount' => $amount,
            'approved_at'     => now(),
            'admin_notes'     => $request->notes ?: $lr->admin_notes,
            'reviewed_at'     => now(),
        ]);

        // 2. Créditer le solde de l'utilisateur
        $lr->user->increment('balance', $amount);

        // 3. Créer le prêt actif
        $durationYears = $lr->duration_months / 12;
        Loan::create([
            'user_id'           => $lr->user_id,
            'type'              => $lr->loan_type,
            'amount'            => $amount,
            'remaining'         => $amount,
            'monthly'           => (int) round($amount / $lr->duration_months * 1.05),
            'rate'              => 3.5,
            'start_date'        => now()->toDateString(),
            'end_date'          => now()->addMonths($lr->duration_months)->toDateString(),
            'progress'          => 0,
            'status'            => 'active',
            'next_payment_date' => now()->addMonth()->toDateString(),
        ]);

        // 4. Générer le document d'approbation PDF
        try {
            (new PdfService)->generateLoanDocument($lr, 'approved', $lr->user->locale ?? config('app.locale', 'fr'));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Approval PDF generation failed: ' . $e->getMessage());
        }

        // 5. Notifier le client
        Mail::to($lr->user->email)->queue(new LoanRequestStatusChanged($lr));

        return back()->with('success', 'Prêt approuvé ! ' . number_format($amount, 0, ',', ' ') . ' € crédités sur le compte du client.');
    }

    /* ── Supprimer une demande ───────────────────────────────── */
    public function deleteRequest(int $id)
    {
        $lr = LoanRequest::findOrFail($id);

        if ($lr->status === 'approved') {
            return back()->with('error', 'Un prêt déjà approuvé ne peut pas être supprimé.');
        }

        // Supprimer les fichiers associés
        if ($lr->contract_path)        Storage::disk('local')->delete($lr->contract_path);
        if ($lr->signed_contract_path) Storage::disk('local')->delete($lr->signed_contract_path);

        $lr->documents()->delete();
        $lr->delete();

        return redirect()->route('admin.requests')->with('success', 'Demande #' . str_pad($id, 5, '0', STR_PAD_LEFT) . ' supprimée.');
    }

    /* ── Rejeter une demande ─────────────────────────────────── */
    public function rejectRequest(Request $request, int $id)
    {
        $lr = LoanRequest::with('user')->findOrFail($id);

        if (in_array($lr->status, ['approved'])) {
            return back()->with('error', 'Un prêt déjà approuvé ne peut pas être rejeté.');
        }

        $lr->update([
            'status'      => 'rejected',
            'admin_notes' => $request->input('notes', $lr->admin_notes),
            'reviewed_at' => now(),
        ]);

        Mail::to($lr->user->email)->queue(new LoanRequestStatusChanged($lr));

        return back()->with('success', 'Demande refusée.');
    }

    /* ── Prêts actifs ───────────────────────────────────────── */
    public function loans(Request $request)
    {
        $q = Loan::with('user')->latest();

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }

        return view('admin.loans', [
            'loans' => $q->paginate(15)->withQueryString(),
            'users' => User::where('is_admin', false)->orderBy('name')->get(['id', 'name', 'email']),
        ]);
    }

    public function createLoan(Request $request)
    {
        $data = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'type'              => 'required|string|max:50',
            'amount'            => 'required|integer|min:1',
            'remaining'         => 'required|integer|min:0',
            'monthly'           => 'required|integer|min:1',
            'rate'              => 'required|numeric|min:0|max:100',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after:start_date',
            'progress'          => 'required|integer|min:0|max:100',
            'status'            => 'required|in:active,closed,late',
            'next_payment_date' => 'nullable|date',
        ]);

        Loan::create($data);

        return back()->with('success', 'Prêt créé avec succès.');
    }

    public function updateLoan(Request $request, int $id)
    {
        $data = $request->validate([
            'remaining'         => 'required|integer|min:0',
            'monthly'           => 'required|integer|min:1',
            'progress'          => 'required|integer|min:0|max:100',
            'status'            => 'required|in:active,closed,late',
            'next_payment_date' => 'nullable|date',
        ]);

        Loan::findOrFail($id)->update($data);

        return back()->with('success', 'Prêt mis à jour.');
    }

    /* ── Suppressions ───────────────────────────────────────── */
    public function deleteUser(int $id)
    {
        $user = User::findOrFail($id);
        abort_if($user->is_admin, 403, 'Impossible de supprimer un administrateur.');
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé.');
    }

    public function deleteLoan(int $id)
    {
        Loan::findOrFail($id)->delete();
        return back()->with('success', 'Prêt supprimé.');
    }

    public function deleteMessage(int $id)
    {
        Message::findOrFail($id)->delete();
        return back()->with('success', 'Message supprimé.');
    }

    public function deleteTransfer(int $id)
    {
        Transfer::findOrFail($id)->delete();
        return redirect()->route('admin.transfers')->with('success', 'Virement supprimé.');
    }

    public function deleteContact(int $id)
    {
        \App\Models\ContactRequest::findOrFail($id)->delete();
        return redirect()->route('admin.contacts')->with('success', 'Contact supprimé.');
    }

    public function deleteRdvRequest(int $id)
    {
        \App\Models\AppointmentRequest::findOrFail($id)->delete();
        return redirect()->route('admin.contacts')->with('success', 'Demande de RDV supprimée.');
    }

    public function deleteChatSession(\App\Models\ChatSession $session)
    {
        $session->delete();
        return redirect()->route('admin.chat.index')->with('success', 'Conversation supprimée.');
    }

    /* ── Messagerie ─────────────────────────────────────────── */
    public function messages(Request $request)
    {
        // Tous les users non-admin, triés par dernier message (ceux sans message en bas)
        $users = User::where('is_admin', false)
            ->withCount(['messages as unread_count' => function ($q) {
                $q->where('direction', 'inbound')->where('read', false);
            }])
            ->with(['messages' => fn($q) => $q->latest()->limit(1)])
            ->get()
            ->sortByDesc(function ($u) {
                return optional($u->messages->first())->created_at?->timestamp ?? 0;
            })
            ->values();

        $allUsers = $users;

        $selectedUserId = $request->input('user_id')
            ? (int) $request->input('user_id')
            : ($users->first()?->id ?? null);

        $conversation = collect();
        if ($selectedUserId) {
            // Marquer les messages inbound (user → admin) comme lus
            Message::where('user_id', $selectedUserId)
                ->where('direction', 'inbound')
                ->where('read', false)
                ->update(['read' => true]);

            $conversation = Message::where('user_id', $selectedUserId)->orderBy('created_at', 'asc')->get();
        }

        return view('admin.messages', compact('users', 'allUsers', 'selectedUserId', 'conversation'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'body'           => 'required|string|max:2000',
            'subject'        => 'nullable|string|max:200',
            'attachment'     => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'library_doc_id' => 'nullable|integer|exists:admin_template_documents,id',
        ]);

        $attachmentPath = null;
        $attachmentName = null;

        if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
            $file = $request->file('attachment');
            $attachmentName = $file->getClientOriginalName();
            $attachmentPath = $file->store('attachments/' . $request->user_id, 'local');
        } elseif ($request->filled('library_doc_id')) {
            $libDoc = AdminTemplateDocument::find($request->library_doc_id);
            if ($libDoc && Storage::disk('local')->exists($libDoc->file_path)) {
                $attachmentPath = $libDoc->file_path;
                $attachmentName = $libDoc->original_name;
            }
        }

        $msg = Message::create([
            'user_id'         => $request->user_id,
            'direction'       => 'outbound',
            'body'            => $request->body,
            'subject'         => $request->input('subject', 'Message de votre conseiller'),
            'read'            => false,
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
        ]);

        $msg->load('user');
        if ($msg->user) {
            Mail::to($msg->user->email)->queue(new AdvisorMessage($msg));

            // Notification push navigateur
            try {
                (new PushService)->sendToUser(
                    $msg->user,
                    'Nouveau message de KapitalStark',
                    $msg->subject ?? Str::limit($msg->body, 80),
                    route('dashboard.messages')
                );
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Push notification failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.messages', ['user_id' => $request->user_id])
            ->with('success', 'Message envoyé au client.');
    }

    /**
     * Envoie le code de déblocage d'un palier au client via messagerie interne uniquement.
     * Pas d'email automatique — l'admin contrôle explicitement l'envoi.
     */
    public function sendUnlockCode(Request $request, Transfer $transfer)
    {
        if ($transfer->status !== 'paused') {
            return back()->with('error', 'Ce virement n\'est pas en pause.');
        }

        $activeLevel = $transfer->activePausedLevel();
        if (!$activeLevel) {
            return back()->with('error', 'Aucun code actif à envoyer.');
        }

        $code = $activeLevel['unlock_code'] ?? '';
        $user = $transfer->user;

        Message::create([
            'user_id'   => $user->id,
            'direction' => 'outbound',
            'subject'   => 'Code de déblocage — Virement #' . str_pad($transfer->id, 5, '0', STR_PAD_LEFT),
            'body'      => "Bonjour {$user->name},\n\nVotre virement nécessite un code de déblocage pour continuer.\n\nVotre code : {$code}\n\nRendez-vous sur votre espace client, page Virements, et entrez ce code dans le formulaire de déblocage.\n\nCordialement,\nL'équipe KapitalStark",
            'read'      => false,
        ]);

        return back()->with('success', "Code {$code} envoyé à {$user->name} via la messagerie.");
    }

    public function markMessageRead(int $id)
    {
        Message::findOrFail($id)->update(['read' => true]);
        return back()->with('success', 'Message marqué comme lu.');
    }

    public function pollMessages(int $userId)
    {
        $since = request()->validate(['since' => 'nullable|date'])['since'] ?? null;
        $q = Message::where('user_id', $userId)->orderBy('created_at', 'asc');
        if ($since) {
            $q->where('created_at', '>', $since);
        }
        $msgs = $q->limit(100)->get()->map(fn ($m) => [
            'id'              => $m->id,
            'from'            => $m->direction === 'inbound' ? 'user' : 'admin',
            'body'            => $m->body,
            'subject'         => $m->subject,
            'at'              => $m->created_at->format('d/m/Y H:i'),
            'created_at'      => $m->created_at->toISOString(),
            'attachment_name' => $m->attachment_name,
            'attachment_url'  => $m->attachment_path ? route('admin.messages.download', $m->id) : null,
        ]);
        return response()->json(['messages' => $msgs]);
    }

    public function downloadAttachment(int $id)
    {
        $msg = Message::findOrFail($id);
        if (!$msg->attachment_path || !Storage::disk('local')->exists($msg->attachment_path)) {
            abort(404);
        }
        return Storage::disk('local')->download($msg->attachment_path, $msg->attachment_name);
    }

    /* ── Rendez-vous ────────────────────────────────────────── */
    public function appointments(Request $request)
    {
        $q = Appointment::with('user')->orderBy('date')->orderBy('time');

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }

        return view('admin.appointments', [
            'appointments' => $q->paginate(15)->withQueryString(),
        ]);
    }

    public function updateAppointment(Request $request, int $id)
    {
        $request->validate([
            'advisor' => 'nullable|string|max:100',
            'status'  => 'required|in:upcoming,past,cancelled',
            'notes'   => 'nullable|string|max:1000',
        ]);

        Appointment::findOrFail($id)->update($request->only('advisor', 'status', 'notes'));

        return back()->with('success', 'Rendez-vous mis à jour.');
    }

    public function deleteAppointment(int $id)
    {
        Appointment::findOrFail($id)->delete();

        return back()->with('success', 'Rendez-vous supprimé.');
    }

    /* ── Utilisateurs ───────────────────────────────────────── */
    public function users(Request $request)
    {
        $q = User::withCount(['loanRequests', 'loans', 'documents'])->latest();

        if ($request->filled('search')) {
            $q->where(function ($sub) use ($request) {
                $sub->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }

        return view('admin.users', [
            'users' => $q->paginate(20)->withQueryString(),
        ]);
    }

    public function showUser(int $id)
    {
        $user = User::with(['loanRequests', 'loans', 'appointments', 'messages', 'documents'])
            ->findOrFail($id);

        return view('admin.user-detail', ['member' => $user]);
    }

    /* ── Contacts & RDV publics ─────────────────────────────── */
    public function contacts()
    {
        return view('admin.contacts', [
            'contacts' => ContactRequest::latest()->paginate(20),
            'rdv'      => AppointmentRequest::latest()->paginate(20),
        ]);
    }

    public function markContactHandled(int $id)
    {
        ContactRequest::findOrFail($id)->update(['handled' => true]);
        return back()->with('success', 'Contact marqué comme traité.');
    }

    public function markRdvHandled(int $id)
    {
        AppointmentRequest::findOrFail($id)->update(['handled' => true]);
        return back()->with('success', 'RDV marqué comme traité.');
    }

    /* ── Virements ──────────────────────────────────────────── */

    public function transfers(Request $request)
    {
        $q = Transfer::with('user')->latest();

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $q->whereHas('user', fn ($u) =>
                $u->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%')
            );
        }

        return view('admin.transfers', [
            'transfers' => $q->paginate(20)->withQueryString(),
        ]);
    }

    public function showTransfer(Transfer $transfer)
    {
        $transfer->load('user');
        return view('admin.transfer-show', compact('transfer'));
    }

    public function validateTransfer(Request $request, Transfer $transfer)
    {
        $request->validate([
            'completion_message' => ['required', 'string', 'max:500'],
            'stop_levels'        => ['nullable', 'array', 'max:10'],
            'stop_levels.*.percentage' => ['required', 'integer', 'min:1', 'max:99'],
            'stop_levels.*.text'       => ['required', 'string', 'max:300'],
        ], [
            'completion_message.required' => 'Le message de fin (100 %) est obligatoire.',
            'stop_levels.max'             => '10 niveaux d\'arrêt maximum.',
        ]);

        if ($transfer->status !== 'pending') {
            return back()->with('error', 'Ce virement ne peut plus être modifié.');
        }

        // Construire les niveaux d'arrêt
        $levels = [];
        foreach ($request->input('stop_levels', []) as $level) {
            if (!empty($level['percentage']) && !empty($level['text'])) {
                $levels[] = [
                    'percentage' => (int) $level['percentage'],
                    'text'       => $level['text'],
                    'reached_at' => null,
                ];
            }
        }

        // Vérifier les pourcentages uniques
        $percentages = array_column($levels, 'percentage');
        if (count($percentages) !== count(array_unique($percentages))) {
            return back()->withErrors(['stop_levels' => 'Les pourcentages doivent être uniques.'])->withInput();
        }

        $transfer->update([
            'status'             => 'approved',
            'stop_levels'        => $levels,
            'completion_message' => $request->completion_message,
            'validated_by'       => Auth::id(),
            'validated_at'       => now(),
        ]);

        return redirect()
            ->route('admin.transfers.show', $transfer)
            ->with('success', 'Virement approuvé — le client peut maintenant l\'exécuter.');
    }

    public function rejectTransfer(Transfer $transfer)
    {
        if (!in_array($transfer->status, ['pending'], true)) {
            return back()->with('error', 'Ce virement ne peut pas être rejeté.');
        }

        $transfer->update(['status' => 'rejected']);

        return redirect()
            ->route('admin.transfers')
            ->with('success', 'Virement rejeté.');
    }

    /* ── Bibliothèque de documents admin ────────────────────── */

    public function templateDocuments(Request $request)
    {
        $q = AdminTemplateDocument::latest();
        if ($request->filled('category')) {
            $q->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $q->where('title', 'like', '%' . $request->search . '%');
        }

        $categories = AdminTemplateDocument::select('category')->distinct()->orderBy('category')->pluck('category');

        return view('admin.documents', [
            'docs'       => $q->paginate(20)->withQueryString(),
            'categories' => $categories,
        ]);
    }

    public function uploadTemplateDocument(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:120',
            'category'    => 'required|string|max:60',
            'description' => 'nullable|string|max:300',
            'file'        => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:20480',
        ], [
            'title.required'    => 'Le titre est obligatoire.',
            'category.required' => 'La catégorie est obligatoire.',
            'file.required'     => 'Veuillez sélectionner un fichier.',
            'file.mimes'        => 'Formats acceptés : PDF, Word, Excel, images.',
            'file.max'          => 'Le fichier ne doit pas dépasser 20 Mo.',
        ]);

        $file      = $request->file('file');
        $stored    = $file->store('admin-templates', 'local');

        AdminTemplateDocument::create([
            'title'         => $request->title,
            'category'      => $request->category,
            'description'   => $request->description,
            'file_path'     => $stored,
            'original_name' => $file->getClientOriginalName(),
            'mime'          => $file->getMimeType(),
            'size_bytes'    => $file->getSize(),
            'uploaded_by'   => Auth::id(),
        ]);

        return redirect()->route('admin.documents')->with('success', 'Document "' . $request->title . '" ajouté à la bibliothèque.');
    }

    public function deleteTemplateDocument(int $id)
    {
        $doc = AdminTemplateDocument::findOrFail($id);
        Storage::disk('local')->delete($doc->file_path);
        $doc->delete();

        return redirect()->route('admin.documents')->with('success', 'Document supprimé.');
    }

    public function downloadTemplateDocument(int $id)
    {
        $doc = AdminTemplateDocument::findOrFail($id);

        if (!Storage::disk('local')->exists($doc->file_path)) {
            abort(404);
        }

        return Storage::disk('local')->download($doc->file_path, $doc->original_name);
    }

    public function templateDocumentsJson()
    {
        $docs = AdminTemplateDocument::orderBy('category')->orderBy('title')
            ->get()
            ->map(fn ($d) => [
                'id'            => $d->id,
                'title'         => $d->title,
                'category'      => $d->category,
                'original_name' => $d->original_name,
                'ext'           => strtoupper(pathinfo($d->original_name, PATHINFO_EXTENSION)),
                'size'          => $d->sizeForHumans(),
                'mime'          => $d->mime,
            ]);

        return response()->json($docs);
    }

    /* ── Chat public (visiteurs anonymes) ───────────────────── */

    public function chatSessions()
    {
        $sessions = ChatSession::with('lastMessage')
            ->withCount(['messages as unread' => fn($q) => $q->where('direction', 'visitor')->where('read', false)])
            ->orderByDesc('last_seen_at')
            ->paginate(30);

        return view('admin.chat-sessions', compact('sessions'));
    }

    public function chatShow(ChatSession $session)
    {
        $messages = $session->messages()->orderBy('id')->get();

        // Marquer messages visiteur comme lus
        $session->messages()->where('direction', 'visitor')->where('read', false)->update(['read' => true]);

        return view('admin.chat-show', compact('session', 'messages'));
    }

    public function chatReply(Request $request, ChatSession $session)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        ChatMessage::create([
            'session_id' => $session->id,
            'direction'  => 'admin',
            'body'       => $request->body,
        ]);

        return back()->with('success', 'Réponse envoyée.');
    }

    public function chatPoll(Request $request, ChatSession $session)
    {
        $since = (int) $request->query('since', 0);

        $messages = $session->messages()
            ->where('direction', 'visitor')
            ->where('id', '>', $since)
            ->orderBy('id')
            ->get(['id', 'body', 'created_at']);

        return response()->json(['messages' => $messages]);
    }
}
