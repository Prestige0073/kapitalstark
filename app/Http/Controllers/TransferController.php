<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransferController extends Controller
{
    /* ── Liste des virements ─────────────────────────────────── */
    public function index()
    {
        $userId = Auth::id();

        $stats = [
            'total'     => Transfer::where('user_id', $userId)->count(),
            'pending'   => Transfer::where('user_id', $userId)->whereIn('status', ['pending', 'approved'])->count(),
            'ongoing'   => Transfer::where('user_id', $userId)->whereIn('status', ['processing', 'paused'])->count(),
            'completed' => Transfer::where('user_id', $userId)->where('status', 'completed')->count(),
            'totalAmt'  => Transfer::where('user_id', $userId)->sum('amount'),
        ];

        $transfers = Transfer::where('user_id', $userId)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('dashboard.transfers.index', compact('transfers', 'stats'));
    }

    /* ── Formulaire ──────────────────────────────────────────── */
    public function create()
    {
        $balance = (float) (Auth::user()->balance ?? 0);
        return view('dashboard.transfers.create', compact('balance'));
    }

    /* ── Soumission ──────────────────────────────────────────── */
    public function store(Request $request)
    {
        $balance = (float) (Auth::user()->balance ?? 0);

        $request->validate([
            'amount'         => ['required', 'numeric', 'min:1', 'max:' . min(100000, max(1, $balance))],
            'recipient_name' => ['required', 'string', 'max:100'],
            'recipient_iban' => ['required', 'string', 'regex:/^[A-Z]{2}\d{2}[A-Z0-9]{1,30}$/'],
            'recipient_bic'  => ['nullable', 'string', 'regex:/^[A-Z]{6}[A-Z0-9]{2}([A-Z0-9]{3})?$/'],
            'label'          => ['nullable', 'string', 'max:140'],
            'note'           => ['nullable', 'string', 'max:500'],
        ], [
            'amount.required'         => 'Le montant est obligatoire.',
            'amount.min'              => 'Le montant minimum est 1 €.',
            'amount.max'              => 'Montant supérieur à votre solde disponible ou au plafond de 100 000 €.',
            'recipient_name.required' => 'Le nom du bénéficiaire est obligatoire.',
            'recipient_iban.required' => "L'IBAN est obligatoire.",
            'recipient_iban.regex'    => "L'IBAN saisi n'est pas valide (format : FR76…).",
            'recipient_bic.regex'     => 'Le BIC/SWIFT saisi n\'est pas valide.',
        ]);

        $transfer = Transfer::create([
            'user_id'        => Auth::id(),
            'amount'         => $request->amount,
            'recipient_name' => $request->recipient_name,
            'recipient_iban' => strtoupper(str_replace(' ', '', $request->recipient_iban)),
            'recipient_bic'  => $request->recipient_bic ? strtoupper($request->recipient_bic) : null,
            'label'          => $request->label,
            'note'           => $request->note,
            'status'         => 'pending',
        ]);

        return redirect()
            ->route('dashboard.transfers.show', $transfer)
            ->with('success', 'Votre demande de virement a été soumise. Un conseiller la traitera prochainement.');
    }

    /* ── Détail / suivi ──────────────────────────────────────── */
    public function show(Transfer $transfer)
    {
        if ($transfer->user_id !== Auth::id()) {
            abort(403);
        }

        return view('dashboard.transfers.show', compact('transfer'));
    }

    /* ── Lancement par l'utilisateur (après approbation admin) ── */
    public function execute(Transfer $transfer)
    {
        if ($transfer->user_id !== Auth::id()) {
            abort(403);
        }

        if ($transfer->status !== 'approved') {
            return back()->with('error', 'Ce virement ne peut pas être exécuté.');
        }

        $transfer->update([
            'status'           => 'processing',
            'started_at'       => now(),
            'base_progress'    => 0,
            'progress'         => 0,
        ]);

        return redirect()->route('dashboard.transfers.show', $transfer);
    }

    /* ── API JSON : état courant (polling client) ────────────── */
    public function status(Transfer $transfer)
    {
        if ($transfer->user_id !== Auth::id()) {
            abort(403);
        }

        // ── Calcul temps réel si en cours ────────────────────────
        if ($transfer->status === 'processing') {
            $current = $transfer->calculateProgress();

            // Vérifier si un stop level est atteint (premier non-franchi)
            $levels = $transfer->stop_levels ?? [];
            $paused = false;

            foreach ($levels as $i => $level) {
                if (!empty($level['reached_at'])) {
                    continue; // déjà traité
                }

                if ($current >= (int) $level['percentage']) {
                    // Atteint — générer un code et mettre en pause
                    $code = strtoupper(Str::random(3)) . '-' . strtoupper(Str::random(4));
                    $levels[$i]['reached_at']   = now()->toIso8601String();
                    $levels[$i]['unlock_code']  = $code;
                    $levels[$i]['code_used_at'] = null;

                    $transfer->update([
                        'status'      => 'paused',
                        'progress'    => (int) $level['percentage'],
                        'stop_levels' => $levels,
                    ]);

                    $transfer->refresh();
                    $paused = true;
                    break;
                }
            }

            // Vérifier si 100 % atteint (aucun stop level bloquant)
            if (!$paused && $current >= 100) {
                $transfer->update([
                    'status'       => 'completed',
                    'progress'     => 100,
                    'completed_at' => now(),
                ]);
                $transfer->refresh();
            } elseif (!$paused) {
                // Persister la progression en DB toutes les ~5 %
                if ($current >= $transfer->progress + 5) {
                    $transfer->update(['progress' => $current]);
                    $transfer->refresh();
                }
            }
        }

        $progress = $transfer->status === 'processing'
            ? $transfer->calculateProgress()
            : $transfer->progress;

        // Ne jamais exposer unlock_code au navigateur client
        $safeLevels = array_map(fn ($l) => [
            'percentage' => $l['percentage'],
            'text'       => $l['text'] ?? '',
            'reached_at' => $l['reached_at'] ?? null,
        ], $transfer->sortedStopLevels());

        return response()->json([
            'status'             => $transfer->status,
            'status_label'       => $transfer->statusLabel(),
            'progress'           => $progress,
            'stop_levels'        => $safeLevels,
            'completion_message' => $transfer->completion_message,
            'current_text'       => $transfer->currentLevelText(),
            'completed_at'       => $transfer->completed_at?->format('d/m/Y à H:i'),
        ]);
    }

    /* ── Déblocage par code (stop level) ─────────────────────── */
    public function unlock(Transfer $transfer, Request $request)
    {
        if ($transfer->user_id !== Auth::id()) {
            abort(403);
        }

        if ($transfer->status !== 'paused') {
            return back()->withErrors(['code' => "Ce virement n'est pas en attente de déblocage."]);
        }

        $entered = strtoupper(trim($request->input('code', '')));
        $levels  = $transfer->stop_levels ?? [];
        $found   = false;

        foreach ($levels as &$level) {
            if (
                isset($level['unlock_code']) &&
                $level['unlock_code'] === $entered &&
                empty($level['code_used_at'])
            ) {
                $level['code_used_at'] = now()->toIso8601String();
                $found = true;
                break;
            }
        }
        unset($level);

        if (!$found) {
            return back()->withErrors(['code' => 'Code incorrect ou déjà utilisé.'])->withInput();
        }

        // Reprendre depuis le % de pause — le calcul temps réel repart de là
        $transfer->update([
            'stop_levels'    => $levels,
            'status'         => 'processing',
            'started_at'     => now(),
            'base_progress'  => (int) $transfer->progress,
        ]);

        return redirect()->route('dashboard.transfers.show', $transfer);
    }

    /* ── Téléchargement du reçu PDF ─────────────────────────── */
    public function downloadReceipt(Transfer $transfer)
    {
        abort_if($transfer->user_id !== Auth::id(), 403);
        abort_if($transfer->status !== 'completed', 404);

        $pdf = (new PdfService)->generateTransferPdf(
            $transfer,
            Auth::user(),
            app()->getLocale()
        );

        $filename = 'recu-virement-' . str_pad($transfer->id, 5, '0', STR_PAD_LEFT) . '-' . now()->format('Ymd') . '.pdf';

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
