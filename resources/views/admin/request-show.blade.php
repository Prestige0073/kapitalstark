@extends('layouts.admin')
@section('title', 'Demande #' . str_pad($lr->id, 5, '0', STR_PAD_LEFT))

@section('content')

@if(session('success'))
<div class="admin-alert admin-alert--success" style="margin-bottom:20px;">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="admin-alert admin-alert--error" style="margin-bottom:20px;">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    {{ session('error') }}
</div>
@endif

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
    <div>
        <a href="{{ route('admin.requests') }}" style="font-size:13px;color:#718096;display:inline-flex;align-items:center;gap:5px;text-decoration:none;margin-bottom:6px;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Demandes de prêt
        </a>
        <h2 style="font-size:20px;font-weight:700;color:#1a2540;margin:0;">
            Demande #REF-{{ str_pad($lr->id, 5, '0', STR_PAD_LEFT) }}
        </h2>
    </div>
    @php
        $cls = match($lr->status) {
            'approved'                          => 'success',
            'rejected'                          => 'danger',
            'validated','confirmed'             => 'info',
            'documents_submitted','under_review'=> 'warning',
            default                             => 'muted',
        };
    @endphp
    <span class="admin-badge admin-badge--{{ $cls }}" style="font-size:13px;padding:6px 14px;">
        {{ $lr->statusLabel() }}
    </span>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">

    {{-- ── Colonne principale ──────────────────────────────── --}}
    <div>

        {{-- Informations du dossier --}}
        <div class="admin-card" style="margin-bottom:20px;">
            <div class="admin-card__header">
                <span class="admin-card__title">Informations du dossier</span>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;">
                @foreach([
                    ['Client',                  $lr->user->name . ' (' . $lr->user->email . ')'],
                    ['Type de prêt',             ucwords(str_replace(['-','_'],' ',$lr->loan_type))],
                    ['Montant demandé',          number_format($lr->amount, 0, ',', ' ') . ' €'],
                    ['Durée',                    $lr->duration_months . ' mois'],
                    ['Revenus mensuels',         number_format($lr->income, 0, ',', ' ') . ' €'],
                    ['Charges mensuelles',       number_format($lr->charges, 0, ',', ' ') . ' €'],
                    ['Situation professionnelle',ucfirst($lr->employment)],
                    ['Taux d\'endettement',      round(($lr->charges / max($lr->income, 1)) * 100, 1) . ' %'],
                    ['Date de dépôt',            $lr->created_at->format('d/m/Y à H:i')],
                    ['Dernière mise à jour',     $lr->updated_at->format('d/m/Y à H:i')],
                ] as [$lbl, $val])
                <div style="padding:12px 22px;border-bottom:1px solid #f0f4ff;">
                    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:#8a9bb8;margin-bottom:3px;">{{ $lbl }}</div>
                    <div style="font-size:13px;font-weight:600;color:#1a2540;">{{ $val }}</div>
                </div>
                @endforeach
            </div>
            <div style="padding:14px 22px;border-bottom:1px solid #f0f4ff;">
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:#8a9bb8;margin-bottom:4px;">Objet du prêt</div>
                <div style="font-size:13px;color:#1a2540;line-height:1.6;">{{ $lr->purpose }}</div>
            </div>
            @if($lr->admin_notes)
            <div style="padding:14px 22px;background:rgba(245,158,11,.04);">
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:#b45309;margin-bottom:4px;">Note interne</div>
                <div style="font-size:13px;color:#1a2540;line-height:1.6;">{{ $lr->admin_notes }}</div>
            </div>
            @endif
            @if($lr->approved_amount)
            <div style="padding:14px 22px;background:rgba(34,197,94,.04);">
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:#15803d;margin-bottom:4px;">Montant accordé</div>
                <div style="font-size:18px;font-weight:800;color:#15803d;font-family:monospace;">{{ number_format($lr->approved_amount, 2, ',', ' ') }} €</div>
                @if($lr->approved_at)<div style="font-size:11px;color:#718096;margin-top:2px;">Le {{ $lr->approved_at->format('d/m/Y à H:i') }}</div>@endif
            </div>
            @endif
        </div>

        {{-- Documents --}}
        <div class="admin-card" style="margin-bottom:20px;">
            <div class="admin-card__header">
                <span class="admin-card__title">Documents soumis</span>
                <span style="font-size:12px;color:#718096;">{{ $lr->documents->count() }} fichier(s)</span>
            </div>
            @if($lr->signed_contract_path)
            <div style="display:flex;align-items:center;gap:14px;padding:14px 20px;border-bottom:1px solid #f0f4ff;background:rgba(34,197,94,.03);">
                <div style="width:36px;height:36px;background:rgba(34,197,94,.1);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#15803d;flex-shrink:0;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:700;color:#1a2540;">Contrat signé</div>
                    <div style="font-size:11px;color:#718096;">Reçu le {{ $lr->updated_at->format('d/m/Y') }}</div>
                </div>
                <span style="font-size:11px;font-weight:700;background:rgba(34,197,94,.1);color:#15803d;padding:3px 10px;border-radius:20px;">✓ Reçu</span>
            </div>
            @else
            <div style="padding:14px 20px;border-bottom:1px solid #f0f4ff;font-size:13px;color:#b45309;">⏳ Contrat signé non encore reçu</div>
            @endif

            @forelse($lr->documents as $doc)
            <div style="display:flex;align-items:center;gap:14px;padding:12px 20px;border-bottom:1px solid #f0f4ff;">
                <div style="width:36px;height:36px;background:rgba(38,123,241,.08);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#267BF1;flex-shrink:0;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:600;color:#1a2540;">{{ $doc->original_name }}</div>
                    <div style="font-size:11px;color:#718096;">{{ $doc->formattedSize() }} · {{ $doc->created_at->format('d/m/Y') }}</div>
                </div>
                <span style="font-size:11px;color:#718096;">{{ $doc->category }}</span>
            </div>
            @empty
            @if(!$lr->signed_contract_path)
            <div style="padding:30px;text-align:center;color:#718096;font-size:13px;">Aucun document soumis</div>
            @endif
            @endforelse
        </div>

        {{-- Timeline --}}
        <div class="admin-card">
            <div class="admin-card__header"><span class="admin-card__title">Historique du dossier</span></div>
            <div style="padding:16px 22px;">
                @php
                    $timeline = [
                        ['Dossier soumis',     $lr->created_at,   1],
                        ['Contrat envoyé',      null,              2],
                        ['Documents reçus',     null,              3],
                        ['Dossier validé',      $lr->reviewed_at,  4],
                        ['Demande confirmée',   $lr->confirmed_at, 5],
                        ['Prêt approuvé',       $lr->approved_at,  6],
                    ];
                    $stepIdx = $lr->stepIndex();
                @endphp
                @foreach($timeline as $i => [$tlbl, $tdate, $tStep])
                @php $done = $stepIdx >= $tStep; @endphp
                <div style="display:flex;gap:14px;margin-bottom:12px;opacity:{{ $done ? '1' : '0.3' }};">
                    <div style="display:flex;flex-direction:column;align-items:center;">
                        <div style="width:28px;height:28px;border-radius:50%;background:{{ $done ? '#267BF1' : '#e5e7eb' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        @if(!$loop->last)<div style="width:2px;flex:1;background:{{ $done ? '#267BF1' : '#e5e7eb' }};min-height:16px;margin:3px 0;"></div>@endif
                    </div>
                    <div style="padding-top:4px;padding-bottom:8px;">
                        <div style="font-size:13px;font-weight:700;color:#1a2540;">{{ $tlbl }}</div>
                        @if($tdate)<div style="font-size:11px;color:#718096;">{{ $tdate->format('d/m/Y à H:i') }}</div>@endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ── Panneau actions ─────────────────────────────────── --}}
    <div>

        @if($lr->status === 'pending')
        <div class="admin-card" style="margin-bottom:16px;">
            <div class="admin-card__header"><span class="admin-card__title">Envoyer le contrat</span></div>
            <div style="padding:16px 20px;">
                <form action="{{ route('admin.requests.contract', $lr->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="margin-bottom:12px;">
                        <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#4a5878;display:block;margin-bottom:5px;">Contrat PDF <span style="color:#ef4444;">*</span></label>
                        <input type="file" name="contract" accept=".pdf" required style="display:block;width:100%;padding:8px 12px;border:2px solid rgba(38,123,241,.15);border-radius:8px;font-size:13px;">
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#4a5878;display:block;margin-bottom:5px;">Note pour le client</label>
                        <textarea name="notes" rows="2" style="width:100%;padding:8px 12px;border:2px solid rgba(38,123,241,.15);border-radius:8px;font-size:13px;resize:vertical;font-family:inherit;" placeholder="Instructions…"></textarea>
                    </div>
                    <button type="submit" class="admin-btn admin-btn--primary" style="width:100%;">Envoyer le contrat</button>
                </form>
            </div>
        </div>

        @elseif(in_array($lr->status, ['documents_submitted','under_review']))
        <div class="admin-card" style="margin-bottom:16px;">
            <div class="admin-card__header"><span class="admin-card__title">Valider le dossier</span></div>
            <div style="padding:16px 20px;">
                <p style="font-size:13px;color:#718096;margin-bottom:14px;">
                    {{ $lr->documents->count() }} document(s) · {{ $lr->signed_contract_path ? '✓ Contrat signé reçu' : '⚠ Contrat signé manquant' }}
                </p>
                <form action="{{ route('admin.requests.validate', $lr->id) }}" method="POST">
                    @csrf
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#4a5878;display:block;margin-bottom:5px;">Commentaire</label>
                        <textarea name="notes" rows="2" style="width:100%;padding:8px 12px;border:2px solid rgba(38,123,241,.15);border-radius:8px;font-size:13px;resize:vertical;font-family:inherit;" placeholder="Dossier complet…"></textarea>
                    </div>
                    <button type="submit" class="admin-btn admin-btn--primary" style="width:100%;">Valider le dossier</button>
                </form>
            </div>
        </div>

        @elseif(in_array($lr->status, ['validated','confirmed']))
        <div class="admin-card" style="margin-bottom:16px;border:1px solid rgba(34,197,94,.25);">
            <div class="admin-card__header" style="background:rgba(34,197,94,.04);"><span class="admin-card__title">Approuver le prêt</span></div>
            <div style="padding:16px 20px;">
                <form action="{{ route('admin.requests.approve', $lr->id) }}" method="POST">
                    @csrf
                    <div style="margin-bottom:12px;">
                        <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#4a5878;display:block;margin-bottom:5px;">Montant accordé (€) <span style="color:#ef4444;">*</span></label>
                        <input type="number" name="approved_amount" value="{{ $lr->amount }}" min="1" required
                               style="width:100%;padding:10px 14px;border:2px solid rgba(34,197,94,.3);border-radius:8px;font-size:15px;font-weight:700;font-family:monospace;color:#15803d;outline:none;">
                        <small style="font-size:11px;color:#718096;display:block;margin-top:4px;">Crédité immédiatement sur le compte client.</small>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#4a5878;display:block;margin-bottom:5px;">Note finale</label>
                        <textarea name="notes" rows="2" style="width:100%;padding:8px 12px;border:2px solid rgba(38,123,241,.15);border-radius:8px;font-size:13px;resize:vertical;font-family:inherit;"></textarea>
                    </div>
                    <button type="submit" style="width:100%;background:#22c55e;border:none;color:#fff;padding:11px;border-radius:10px;font-weight:700;cursor:pointer;font-size:14px;">
                        Approuver et créditer
                    </button>
                </form>
            </div>
        </div>

        @elseif($lr->status === 'approved')
        <div class="admin-card" style="margin-bottom:16px;">
            <div style="padding:24px;text-align:center;">
                <div style="width:52px;height:52px;background:rgba(34,197,94,.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <strong style="font-size:15px;color:#15803d;">Prêt accordé</strong>
                <p style="font-size:20px;font-weight:800;color:#15803d;font-family:monospace;margin:6px 0 2px;">{{ number_format($lr->approved_amount, 0, ',', ' ') }} €</p>
                @if($lr->approved_at)<p style="font-size:12px;color:#718096;">Le {{ $lr->approved_at->format('d/m/Y') }}</p>@endif
            </div>
        </div>
        @endif

        @if(!in_array($lr->status, ['approved','rejected']))
        <div class="admin-card" style="margin-bottom:16px;">
            <div class="admin-card__header"><span class="admin-card__title" style="color:#dc2626;">Refuser</span></div>
            <div style="padding:16px 20px;">
                <form action="{{ route('admin.requests.reject', $lr->id) }}" method="POST">
                    @csrf
                    <div style="margin-bottom:12px;">
                        <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#4a5878;display:block;margin-bottom:5px;">Motif (optionnel)</label>
                        <textarea name="notes" rows="2" style="width:100%;padding:8px 12px;border:2px solid rgba(239,68,68,.2);border-radius:8px;font-size:13px;resize:vertical;font-family:inherit;" placeholder="Dossier incomplet…"></textarea>
                    </div>
                    <button type="submit" style="width:100%;background:#ef4444;border:none;color:#fff;padding:10px;border-radius:10px;font-weight:700;cursor:pointer;font-size:14px;"
                            onclick="return confirm('Confirmer le refus de cette demande ?')">
                        Refuser la demande
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- Info client --}}
        <div class="admin-card">
            <div class="admin-card__header"><span class="admin-card__title">Client</span></div>
            <div style="padding:16px 20px;">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
                    <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#267BF1,#1A56B0);display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-size:14px;flex-shrink:0;">
                        {{ strtoupper(substr($lr->user->name ?? 'U', 0, 2)) }}
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#1a2540;">{{ $lr->user->name }}</div>
                        <div style="font-size:12px;color:#718096;">{{ $lr->user->email }}</div>
                    </div>
                </div>
                <div style="font-size:12px;color:#718096;margin-bottom:12px;">
                    Solde actuel : <strong style="color:#267BF1;font-family:monospace;">{{ number_format($lr->user->balance ?? 0, 2, ',', ' ') }} €</strong>
                </div>
                <a href="{{ route('admin.users.show', $lr->user->id) }}" class="admin-btn admin-btn--outline" style="width:100%;justify-content:center;display:flex;">
                    Voir le profil client
                </a>
            </div>
        </div>

    </div>
</div>

@endsection

@section('styles')
<style>
.admin-alert { display:flex;align-items:center;gap:10px;padding:13px 18px;border-radius:12px;font-size:14px;font-weight:600; }
.admin-alert--success { background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);color:#15803d; }
.admin-alert--error   { background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#dc2626; }
@media (max-width:1000px) { div[style*="grid-template-columns:1fr 340px"] { grid-template-columns:1fr !important; } }
</style>
@endsection
