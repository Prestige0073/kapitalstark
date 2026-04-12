<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\LoanRequest;
use App\Models\Transfer;
use App\Models\Appointment;
use App\Models\Message;
use App\Models\Document;
use App\Models\Loan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\LoanRequestReceived;
use App\Mail\AppointmentConfirmed;
use App\Models\PushSubscription;
use App\Services\PdfService;

class DashboardController extends Controller
{
    public function index()
    {
        $requests = LoanRequest::where('user_id', Auth::id())->latest()->get()
            ->map(fn ($r) => [
                'id'     => $r->id,
                'type'   => ucfirst(str_replace('_', ' ', $r->loan_type)),
                'icon'   => '📋',
                'amount' => $r->amount,
                'date'   => $r->created_at->format('Y-m-d'),
                'status' => $r->status,
                'step'   => $r->stepIndex(),
                'steps'  => ['Dossier déposé', 'Analyse en cours', 'Offre émise', 'Signé'],
            ])->toArray();

        $loans = Loan::where('user_id', Auth::id())->where('status', 'active')->latest()->get()
            ->map(fn ($l) => [
                'id'        => $l->id,
                'type'      => $l->typeLabel(),
                'icon'      => $l->typeIcon(),
                'amount'    => $l->amount,
                'remaining' => $l->remaining,
                'monthly'   => $l->monthly,
                'rate'      => $l->rate,
                'start'     => $l->start_date->format('Y-m-d'),
                'end'       => $l->end_date->format('Y-m-d'),
                'progress'  => $l->progress,
                'status'    => $l->status,
                'next_date' => $l->next_payment_date?->format('Y-m-d'),
            ])->toArray();

        // Notifications réelles basées sur les données DB
        $notifs = [];
        foreach (Loan::where('user_id', Auth::id())->where('status', 'active')->get() as $l) {
            if ($l->next_payment_date) {
                $days = now()->diffInDays($l->next_payment_date, false);
                if ($days >= 0 && $days <= 15) {
                    $notifs[] = ['icon' => '💳', 'text' => 'Prélèvement de ' . number_format($l->monthly, 0, ',', ' ') . ' € le ' . $l->next_payment_date->format('d/m'), 'time' => 'Dans ' . $days . ' jour' . ($days > 1 ? 's' : ''), 'color' => 'blue'];
                }
            }
        }
        foreach (LoanRequest::where('user_id', Auth::id())->where('status', 'analysis')->latest()->take(2)->get() as $r) {
            $notifs[] = ['icon' => '📋', 'text' => 'Votre demande de prêt ' . $r->loan_type . ' est en cours d\'analyse', 'time' => $r->updated_at->diffForHumans(), 'color' => 'warning'];
        }

        // Virements récents
        $userId = Auth::id();
        $recentTransfers = Transfer::where('user_id', $userId)->latest()->take(3)->get();
        $transferStats = [
            'pending'  => Transfer::where('user_id', $userId)->whereIn('status', ['pending', 'approved'])->count(),
            'ongoing'  => Transfer::where('user_id', $userId)->whereIn('status', ['processing', 'paused'])->count(),
            'paused'   => Transfer::where('user_id', $userId)->where('status', 'paused')->count(),
        ];

        return view('dashboard.index', [
            'user'            => Auth::user(),
            'loans'           => $loans,
            'requests'        => $requests,
            'notifs'          => $notifs,
            'recentTransfers' => $recentTransfers,
            'transferStats'   => $transferStats,
        ]);
    }

    public function loans()
    {
        $loans = Loan::where('user_id', Auth::id())->latest()->get()
            ->map(fn ($l) => [
                'id'        => $l->id,
                'type'      => $l->typeLabel(),
                'icon'      => $l->typeIcon(),
                'amount'    => $l->amount,
                'remaining' => $l->remaining,
                'monthly'   => $l->monthly,
                'rate'      => $l->rate,
                'start'     => $l->start_date->format('Y-m-d'),
                'end'       => $l->end_date->format('Y-m-d'),
                'progress'  => $l->progress,
                'status'    => $l->status,
                'next_date' => $l->next_payment_date?->format('Y-m-d'),
            ])->toArray();

        return view('dashboard.loans', [
            'user'  => Auth::user(),
            'loans' => $loans,
        ]);
    }

    public function requests()
    {
        $userId   = Auth::id();
        $rawList  = LoanRequest::where('user_id', $userId)->latest()->get();
        $hasActive = $rawList->first()?->isActive() ?? false;

        $requests = $rawList->map(fn ($r) => [
            'id'                   => $r->id,
            'type'                 => ucwords(str_replace(['-', '_'], ' ', $r->loan_type)),
            'amount'               => $r->amount,
            'approved_amount'      => $r->approved_amount,
            'date'                 => $r->created_at->format('Y-m-d'),
            'status'               => $r->status,
            'step'                 => $r->stepIndex(),
            'contract_path'        => $r->contract_path,
            'signed_contract_path' => $r->signed_contract_path,
            'admin_notes'          => $r->admin_notes,
            'docs'                 => Document::where('loan_request_id', $r->id)->get()
                                        ->map(fn ($d) => ['name' => $d->original_name, 'id' => $d->id])
                                        ->toArray(),
        ])->toArray();

        return view('dashboard.requests', [
            'user'      => Auth::user(),
            'requests'  => $requests,
            'hasActive' => $hasActive,
        ]);
    }

    public function documents()
    {
        $docs = Document::where('user_id', Auth::id())->latest()->get()
            ->map(fn ($d) => [
                'id'     => $d->id,
                'name'   => $d->original_name,
                'date'   => $d->created_at->format('d M Y'),
                'size'   => $d->formattedSize(),
                'type'   => 'pdf',
                'loan'   => $d->category,
                'stored' => true,
            ])->toArray();

        return view('dashboard.documents', [
            'user' => Auth::user(),
            'docs' => $docs,
        ]);
    }

    public function uploadDocument(Request $request)
    {
        $request->validate([
            'file'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'category' => 'required|string|max:100',
        ]);

        $file       = $request->file('file');
        $stored     = $file->store('documents/' . Auth::id(), 'local');

        Document::create([
            'user_id'       => Auth::id(),
            'original_name' => $file->getClientOriginalName(),
            'stored_name'   => $stored,
            'category'      => $request->category,
            'mime'          => $file->getMimeType(),
            'size_bytes'    => $file->getSize(),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'ok', 'name' => $file->getClientOriginalName()]);
        }

        return back()->with('success', 'Document envoyé avec succès.');
    }

    public function downloadDocument(int $id)
    {
        $doc = Document::where('user_id', Auth::id())->findOrFail($id);

        if (!Storage::disk('local')->exists($doc->stored_name)) {
            abort(404);
        }

        return Storage::disk('local')->download($doc->stored_name, $doc->original_name);
    }

    public function profile()
    {
        return view('dashboard.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }

    public function messages()
    {
        // Marquer tous les messages du conseiller comme lus
        Message::where('user_id', Auth::id())
            ->where('direction', 'outbound')
            ->where('read', false)
            ->update(['read' => true]);

        $messages = Message::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn ($m) => [
                'id'              => $m->id,
                'direction'       => $m->direction,
                'subject'         => $m->subject,
                'body'            => $m->body,
                'at'              => $m->created_at->format('d/m/Y H:i'),
                'created_at'      => $m->created_at->toISOString(),
                'attachment_name' => $m->attachment_name,
                'attachment_id'   => $m->attachment_path ? $m->id : null,
            ])->toArray();

        return view('dashboard.messages', [
            'user'     => Auth::user(),
            'messages' => $messages,
        ]);
    }

    public function savePushSubscription(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|string',
            'p256dh'   => 'required|string',
            'auth'     => 'required|string',
        ]);

        PushSubscription::updateOrCreate(
            ['user_id' => Auth::id(), 'endpoint' => $request->endpoint],
            ['p256dh'  => $request->p256dh, 'auth' => $request->auth]
        );

        return response()->json(['ok' => true]);
    }

    public function removePushSubscription(Request $request)
    {
        $request->validate(['endpoint' => 'required|string']);

        PushSubscription::where('user_id', Auth::id())
            ->where('endpoint', $request->endpoint)
            ->delete();

        return response()->json(['ok' => true]);
    }

    public function pollNotifications()
    {
        $uid = Auth::id();

        $unread = Message::where('user_id', $uid)
            ->where('direction', 'outbound')
            ->where('read', false)
            ->count();

        $items = [];

        Message::where('user_id', $uid)
            ->where('direction', 'outbound')
            ->where('read', false)
            ->latest()->limit(5)->get()
            ->each(function ($m) use (&$items) {
                $items[] = [
                    'type' => 'message',
                    'text' => 'Nouveau message : ' . ($m->subject ?? Str::limit($m->body, 50)),
                    'url'  => route('dashboard.messages'),
                    'at'   => $m->created_at->diffForHumans(),
                ];
            });

        LoanRequest::where('user_id', $uid)
            ->whereIn('status', ['offer', 'analysis', 'validated', 'approved'])
            ->latest('updated_at')->limit(3)->get()
            ->each(function ($r) use (&$items) {
                $items[] = [
                    'type' => 'request',
                    'text' => 'Demande ' . ucwords(str_replace(['-','_'],' ',$r->loan_type)) . ' : ' . $r->statusLabel(),
                    'url'  => route('dashboard.requests'),
                    'at'   => $r->updated_at->diffForHumans(),
                ];
            });

        return response()->json([
            'unread' => $unread,
            'items'  => array_slice($items, 0, 6),
        ]);
    }

    public function pollMessages(Request $request)
    {
        $request->validate(['since' => 'nullable|date']);

        $since = $request->query('since');
        $q = Message::where('user_id', Auth::id())->orderBy('created_at', 'asc');
        if ($since) {
            $q->where('created_at', '>', $since);
        }
        $msgs = $q->limit(100)->get()->map(fn ($m) => [
            'id'              => $m->id,
            'from'            => $m->direction === 'inbound' ? 'user' : 'advisor',
            'body'            => $m->body,
            'subject'         => $m->subject,
            'at'              => $m->created_at->format('d/m/Y H:i'),
            'created_at'      => $m->created_at->toISOString(),
            'attachment_name' => $m->attachment_name,
            'attachment_url'  => $m->attachment_path ? route('dashboard.messages.attachment', $m->id) : null,
        ]);
        return response()->json(['messages' => $msgs]);
    }

    public function downloadAttachment(int $id)
    {
        $msg = Message::where('user_id', Auth::id())->findOrFail($id);
        if (!$msg->attachment_path || !Storage::disk('local')->exists($msg->attachment_path)) {
            abort(404);
        }
        return Storage::disk('local')->download($msg->attachment_path, $msg->attachment_name);
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $msg = Message::create([
            'user_id'   => Auth::id(),
            'direction' => 'inbound',
            'body'      => $request->message,
            'subject'   => $request->input('subject', 'Message client'),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id'              => $msg->id,
                    'from'            => 'user',
                    'body'            => $msg->body,
                    'subject'         => $msg->subject,
                    'at'              => $msg->created_at->format('d/m/Y H:i'),
                    'created_at'      => $msg->created_at->toISOString(),
                    'attachment_name' => null,
                    'attachment_url'  => null,
                ],
            ]);
        }

        return back()->with('success', 'Message envoyé.');
    }

    public function calendar()
    {
        $today = now()->toDateString();

        // Batch update des rendez-vous passés (un seul UPDATE)
        Appointment::where('user_id', Auth::id())
            ->where('status', 'upcoming')
            ->where('date', '<', $today)
            ->update(['status' => 'past']);

        $dbAppointments = Appointment::where('user_id', Auth::id())
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        $appointments = $dbAppointments->map(fn ($a) => [
            'id'       => $a->id,
            'date'     => $a->date->toDateString(),
            'time'     => $a->time,
            'advisor'  => $a->advisor ?? 'Conseiller KapitalStark',
            'role'     => '',
            'avatar'   => strtoupper(substr($a->advisor ?? 'CK', 0, 2)),
            'subject'  => $a->subject,
            'location' => $a->channelLabel(),
            'status'   => $a->status,
        ])->toArray();

        return view('dashboard.calendar', [
            'user'         => Auth::user(),
            'appointments' => $appointments,
        ]);
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'date'    => 'required|date|after:today',
            'time'    => 'required|string',
            'subject' => 'required|string|max:200',
            'channel' => 'required|string',
        ]);

        $appointment = Appointment::create([
            'user_id' => Auth::id(),
            'date'    => $request->date,
            'time'    => $request->time,
            'subject' => $request->subject,
            'channel' => $request->channel,
            'advisor' => $request->input('advisor'),
            'notes'   => $request->input('notes'),
            'status'  => 'upcoming',
        ]);

        $appointment->load('user');
        Mail::to($appointment->user->email)->queue(new AppointmentConfirmed($appointment));

        return redirect()->route('dashboard.calendar')
            ->with('success', 'Votre rendez-vous a été confirmé. Un email de confirmation vous a été envoyé.');
    }

    public function newRequest()
    {
        $active = LoanRequest::where('user_id', Auth::id())
            ->whereIn('status', LoanRequest::ACTIVE_STATUSES)
            ->latest()->first();

        if ($active) {
            return redirect()->route('dashboard.requests')
                ->with('info', 'Vous avez déjà une demande en cours (réf. #' . str_pad($active->id, 5, '0', STR_PAD_LEFT) . '). Finalisez-la avant d\'en initier une nouvelle.');
        }

        return view('dashboard.new-request', ['user' => Auth::user()]);
    }

    public function card()
    {
        $user = Auth::user();

        // Generate deterministic mock card data seeded from user id
        $seed    = $user->id * 7919;
        $num1    = str_pad(($seed % 9000) + 1000, 4, '0', STR_PAD_LEFT);
        $num2    = str_pad((($seed * 3) % 9000) + 1000, 4, '0', STR_PAD_LEFT);
        $num3    = str_pad((($seed * 7) % 9000) + 1000, 4, '0', STR_PAD_LEFT);
        $num4    = str_pad((($seed * 13) % 9000) + 1000, 4, '0', STR_PAD_LEFT);
        $cvv     = str_pad(($seed % 900) + 100, 3, '0', STR_PAD_LEFT);
        $expiry  = sprintf('%02d/%d', ($user->id % 12) + 1, now()->year + 3 + ($user->id % 3));

        $card = [
            'number'      => "$num1 $num2 $num3 $num4",
            'number_mask' => "•••• •••• •••• $num4",
            'cvv'         => $cvv,
            'expiry'      => $expiry,
            'holder'      => strtoupper($user->name),
            'type'        => 'Visa Infinite',
            'blocked'     => session('card_blocked_' . $user->id, false),
        ];

        // Transactions depuis les prêts approuvés
        $approvedRequests = LoanRequest::where('user_id', $user->id)
            ->where('status', 'approved')
            ->latest('approved_at')
            ->get();

        $transactions = $approvedRequests->map(fn ($r) => [
            'label'  => 'Crédit prêt ' . ucwords(str_replace('_', ' ', $r->loan_type)),
            'amount' => '+' . number_format((float) $r->approved_amount, 2, ',', ' ') . ' €',
            'date'   => $r->approved_at?->format('d/m/Y') ?? $r->updated_at->format('d/m/Y'),
            'credit' => true,
        ])->toArray();

        $balance = (float) ($user->balance ?? 0);
        $limit   = $balance > 0 ? $balance * 1.2 : 0;
        $used    = 0;
        $usedPct = 0;

        return view('dashboard.card', compact('card', 'transactions', 'balance', 'limit', 'used', 'usedPct'));
    }

    public function receipts()
    {
        $user = Auth::user();
        $seed = $user->id * 7919;
        $num4 = str_pad(($seed * 13) % 9000 + 1000, 4, '0', STR_PAD_LEFT);

        // Approval docs
        $approvalDocs = Document::where('user_id', $user->id)
            ->where('category', 'Approbation')
            ->latest()
            ->get();

        // Crédits : prêts approuvés → déblocage de fonds
        $loanCredits = LoanRequest::where('user_id', $user->id)
            ->where('status', 'approved')
            ->latest('updated_at')
            ->get()
            ->map(fn ($r) => [
                'label'  => 'Déblocage prêt ' . ucwords(str_replace(['-', '_'], ' ', $r->loan_type)),
                'amount' => (float) ($r->approved_amount ?? $r->amount),
                'date'   => $r->updated_at->format('d/m/Y'),
                'sort'   => $r->updated_at->timestamp,
                'credit' => true,
            ]);

        // Débits : virements effectués (complétés)
        $transferDebits = Transfer::where('user_id', $user->id)
            ->where('status', 'completed')
            ->latest('completed_at')
            ->get()
            ->map(fn ($t) => [
                'label'  => $t->label ?: ('Virement vers ' . $t->recipient_name),
                'amount' => (float) $t->amount,
                'date'   => ($t->completed_at ?? $t->updated_at)->format('d/m/Y'),
                'sort'   => ($t->completed_at ?? $t->updated_at)->timestamp,
                'credit' => false,
            ]);

        $transactions = $loanCredits->concat($transferDebits)
            ->sortByDesc('sort')
            ->values()
            ->all();

        return view('dashboard.receipts', compact('approvalDocs', 'transactions', 'num4'));
    }

    public function downloadReceipt(Request $request, int $index)
    {
        $user = Auth::user();
        $seed = $user->id * 7919;
        $num4 = str_pad(($seed * 13) % 9000 + 1000, 4, '0', STR_PAD_LEFT);

        $approvedRequests = LoanRequest::where('user_id', $user->id)
            ->where('status', 'approved')
            ->latest('approved_at')
            ->get();

        $transactions = $approvedRequests->map(fn ($r) => [
            'label'     => 'Crédit prêt ' . ucwords(str_replace('_', ' ', $r->loan_type)),
            'amount'    => number_format((float) $r->approved_amount, 2, ',', ' ') . ' €',
            'date'      => $r->approved_at?->format('d/m/Y') ?? $r->updated_at->format('d/m/Y'),
            'credit'    => true,
            'card_last4'=> $num4,
        ])->values()->toArray();

        if (!isset($transactions[$index])) {
            abort(404);
        }

        $pdf = (new PdfService)->generateTransferReceipt($user, $transactions[$index], app()->getLocale());

        $filename = 'recu-' . now()->format('Ymd') . '-' . ($index + 1) . '.pdf';

        return response($pdf, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function toggleCard(Request $request)
    {
        $user    = Auth::user();
        $key     = 'card_blocked_' . $user->id;
        $blocked = !session($key, false);
        session([$key => $blocked]);

        return back()->with('success', $blocked
            ? 'Votre carte a été bloquée temporairement.'
            : 'Votre carte a été débloquée avec succès.');
    }

    public function storeRequest(Request $request)
    {
        // Bloquer si une demande est déjà en cours
        $active = LoanRequest::where('user_id', Auth::id())
            ->whereIn('status', LoanRequest::ACTIVE_STATUSES)
            ->exists();

        if ($active) {
            return redirect()->route('dashboard.requests')
                ->with('error', 'Vous avez déjà une demande en cours de traitement. Vous ne pouvez pas en soumettre une nouvelle.');
        }

        $request->validate([
            'loan_type'  => 'required|string',
            'amount'     => 'required|numeric|min:1000|max:10000000',
            'duration'   => 'required|integer|min:6|max:360',
            'purpose'    => 'required|string|max:500',
            'income'     => 'required|numeric|min:0',
            'charges'    => 'required|numeric|min:0',
            'employment' => 'required|string',
            'consent'    => 'required|accepted',
        ], [
            'consent.required' => 'Vous devez accepter la politique de confidentialité.',
            'consent.accepted' => 'Vous devez accepter la politique de confidentialité.',
        ]);

        $lr = LoanRequest::create([
            'user_id'         => Auth::id(),
            'loan_type'       => $request->loan_type,
            'amount'          => (int) $request->amount,
            'duration_months' => (int) $request->duration,
            'purpose'         => $request->purpose,
            'income'          => (int) $request->income,
            'charges'         => (int) $request->charges,
            'employment'      => $request->employment,
            'status'          => 'pending',
        ]);

        $lr->load('user');
        Mail::to($lr->user->email)->queue(new LoanRequestReceived($lr));

        return redirect()->route('dashboard.requests')
            ->with('success', 'Votre demande a bien été enregistrée. Un conseiller vous contactera sous 24h ouvrées pour vous envoyer le contrat à signer.');
    }

    /* ── Télécharger le contrat envoyé par l'admin ───────────── */
    public function downloadContract(int $id)
    {
        $lr = LoanRequest::where('user_id', Auth::id())->findOrFail($id);

        if (!$lr->contract_path || !Storage::disk('local')->exists($lr->contract_path)) {
            abort(404, 'Contrat introuvable.');
        }

        return Storage::disk('local')->download($lr->contract_path, 'contrat-kapitalstark.pdf');
    }

    /* ── Upload contrat signé + pièces justificatives ────────── */
    public function uploadLoanDocuments(Request $request, int $id)
    {
        $lr = LoanRequest::where('user_id', Auth::id())
            ->where('status', 'contract_sent')
            ->findOrFail($id);

        $request->validate([
            'signed_contract' => 'required|file|mimes:pdf|max:20480',
            'files.*'         => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], [
            'signed_contract.required' => 'Veuillez joindre le contrat signé (PDF).',
            'signed_contract.mimes'    => 'Le contrat signé doit être au format PDF.',
        ]);

        // Stocker le contrat signé
        $signed = $request->file('signed_contract');
        $signedPath = $signed->storeAs(
            'contracts/' . $lr->id,
            'contrat-signe-' . now()->format('Ymd-His') . '.pdf',
            'local'
        );

        $lr->update([
            'status'                => 'documents_submitted',
            'signed_contract_path'  => $signedPath,
        ]);

        // Stocker les pièces justificatives
        foreach ($request->file('files', []) as $file) {
            Document::create([
                'user_id'         => Auth::id(),
                'loan_request_id' => $lr->id,
                'original_name'   => $file->getClientOriginalName(),
                'stored_name'     => $file->store('documents/' . Auth::id(), 'local'),
                'category'        => 'Pièce justificative',
                'mime'            => $file->getMimeType(),
                'size_bytes'      => $file->getSize(),
            ]);
        }

        return redirect()->route('dashboard.requests')
            ->with('success', 'Documents envoyés avec succès. Votre dossier est en cours d\'examen par nos équipes.');
    }

    /* ── Confirmer la demande de prêt (après validation admin) ── */
    public function confirmLoanRequest(int $id)
    {
        $lr = LoanRequest::where('user_id', Auth::id())
            ->where('status', 'validated')
            ->findOrFail($id);

        $lr->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return redirect()->route('dashboard.requests')
            ->with('success', 'Votre demande de prêt a été confirmée. L\'équipe KapitalStark va procéder à la validation finale.');
    }
}
