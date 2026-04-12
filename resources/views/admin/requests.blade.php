@extends('layouts.admin')
@section('title', 'Demandes de prêt')

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

<div class="admin-card">
    <div class="admin-card__header">
        <span class="admin-card__title">Demandes de prêt</span>
        <span style="font-size:12px;color:#718096;">{{ $requests->total() }} résultat(s)</span>
    </div>

    <form method="GET" action="{{ route('admin.requests') }}" class="admin-filters">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un client…">
        <select name="status" onchange="this.form.submit()">
            <option value="">Tous les statuts</option>
            @foreach($allStatuses as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                {{ match($s) {
                    'pending'             => 'En attente',
                    'analysis'            => 'En analyse',
                    'contract_sent'       => 'Contrat envoyé',
                    'documents_submitted' => 'Documents soumis',
                    'under_review'        => 'En étude',
                    'offer'               => 'Offre émise',
                    'validated'           => 'Dossier validé',
                    'confirmed'           => 'Confirmée',
                    'approved'            => 'Prêt accordé',
                    'signed'              => 'Signé',
                    'rejected'            => 'Refusée',
                    default               => ucfirst($s),
                } }}
            </option>
            @endforeach
        </select>
        <button type="submit" class="admin-btn admin-btn--primary admin-btn--sm">Filtrer</button>
        @if(request('search') || request('status'))
        <a href="{{ route('admin.requests') }}" class="admin-btn admin-btn--outline admin-btn--sm">Réinitialiser</a>
        @endif
    </form>

    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Type</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $r)
            <tr>
                <td style="font-family:var(--font-mono);font-size:11px;color:#718096;">#{{ $r->id }}</td>
                <td>
                    <div class="admin-user-chip">
                        <div class="admin-user-chip__av">{{ strtoupper(substr($r->user->name ?? 'U', 0, 2)) }}</div>
                        <div>
                            <div class="admin-user-chip__name">{{ $r->user->name ?? '—' }}</div>
                            <div class="admin-user-chip__email">{{ $r->user->email ?? '' }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ ucwords(str_replace(['-','_'],' ',$r->loan_type)) }}</td>
                <td style="font-family:var(--font-mono);font-weight:700;">
                    {{ number_format($r->amount, 0, ',', ' ') }} €
                    @if($r->approved_amount && $r->approved_amount != $r->amount)
                    <br><small style="color:#22c55e;font-size:10px;">Accordé : {{ number_format($r->approved_amount, 0, ',', ' ') }} €</small>
                    @endif
                </td>
                <td>{{ $r->created_at->format('d/m/Y') }}</td>
                <td>
                    @php
                        $cls = match($r->status) {
                            'approved'                           => 'success',
                            'rejected'                           => 'danger',
                            'validated','confirmed'              => 'info',
                            'documents_submitted','under_review' => 'warning',
                            default                              => 'muted',
                        };
                        $lbl = match($r->status) {
                            'pending'             => 'En attente',
                            'contract_sent'       => 'Contrat envoyé',
                            'documents_submitted' => 'Docs soumis',
                            'under_review'        => 'En étude',
                            'validated'           => 'Validé',
                            'confirmed'           => 'Confirmée',
                            'approved'            => 'Accordé',
                            'rejected'            => 'Refusé',
                            default               => ucfirst($r->status),
                        };
                    @endphp
                    <span class="admin-badge admin-badge--{{ $cls }}">{{ $lbl }}</span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;align-items:center;">
                        <a href="{{ route('admin.requests.show', $r->id) }}"
                           class="admin-btn admin-btn--outline admin-btn--sm">Détail</a>

                        @if($r->status === 'pending')
                            <button type="button" class="admin-btn admin-btn--primary admin-btn--sm"
                                    onclick="openModal('mc-{{ $r->id }}')">Envoyer contrat</button>

                        @elseif(in_array($r->status, ['documents_submitted','under_review']))
                            <button type="button" class="admin-btn admin-btn--primary admin-btn--sm"
                                    onclick="openModal('mv-{{ $r->id }}')">Valider dossier</button>

                        @elseif(in_array($r->status, ['validated','confirmed']))
                            <button type="button" class="admin-btn admin-btn--primary admin-btn--sm"
                                    style="background:#22c55e;border-color:#22c55e;"
                                    onclick="openModal('ma-{{ $r->id }}')">Approuver le prêt</button>

                        @elseif($r->status === 'approved')
                            <span style="font-size:12px;color:#22c55e;font-weight:700;">✓ Accordé</span>
                        @endif

                        @if(!in_array($r->status, ['approved','rejected']))
                            <button type="button" class="admin-btn admin-btn--sm"
                                    style="color:#dc2626;border:1px solid rgba(239,68,68,.3);background:rgba(239,68,68,.05);"
                                    onclick="openModal('mr-{{ $r->id }}')">Rejeter</button>
                        @endif

                        <form action="{{ route('admin.requests.delete', $r->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" class="admin-btn admin-btn--danger admin-btn--sm" title="Supprimer"
                                    onclick="adminConfirm(this, 'Supprimer la demande #{{ $r->id }} de {{ addslashes($r->user->name ?? '') }} ? Action irréversible.')">✕</button>
                        </form>
                    </div>
                </td>
            </tr>

            {{-- ── Modal : envoyer le contrat ─────────────── --}}
            @if($r->status === 'pending')
            <tr class="ar-modal-row" id="mc-{{ $r->id }}" style="display:none;">
                <td colspan="7" style="padding:0;">
                    <div class="ar-inline-form">
                        <strong class="ar-inline-form__title">Envoyer un contrat à {{ $r->user->name ?? '' }}</strong>
                        <form action="{{ route('admin.requests.contract', $r->id) }}" method="POST" enctype="multipart/form-data"
                              style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
                            @csrf
                            <div class="ar-field" style="flex:1;min-width:200px;">
                                <label>Contrat PDF <span class="ar-req">*</span></label>
                                <input type="file" name="contract" accept=".pdf" required class="ar-file">
                            </div>
                            <div class="ar-field" style="flex:2;min-width:200px;">
                                <label>Note pour le client</label>
                                <input type="text" name="notes" class="ar-input" placeholder="Instructions particulières…" value="{{ $r->admin_notes }}">
                            </div>
                            <div style="display:flex;gap:6px;">
                                <button type="submit" class="admin-btn admin-btn--primary admin-btn--sm">Envoyer</button>
                                <button type="button" class="admin-btn admin-btn--outline admin-btn--sm"
                                        onclick="closeModal('mc-{{ $r->id }}')">Annuler</button>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
            @endif

            {{-- ── Modal : valider le dossier ─────────────── --}}
            @if(in_array($r->status, ['documents_submitted','under_review']))
            <tr class="ar-modal-row" id="mv-{{ $r->id }}" style="display:none;">
                <td colspan="7" style="padding:0;">
                    <div class="ar-inline-form">
                        <strong class="ar-inline-form__title">Valider le dossier de {{ $r->user->name ?? '' }}</strong>
                        <p style="font-size:12px;color:#718096;margin:4px 0 12px;">
                            {{ $r->documents->count() }} document(s) soumis.
                            @if($r->signed_contract_path) Contrat signé reçu. @endif
                        </p>
                        <form action="{{ route('admin.requests.validate', $r->id) }}" method="POST"
                              style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
                            @csrf
                            <div class="ar-field" style="flex:1;min-width:200px;">
                                <label>Commentaire (optionnel)</label>
                                <input type="text" name="notes" class="ar-input" placeholder="Dossier complet, tout est en ordre…">
                            </div>
                            <div style="display:flex;gap:6px;">
                                <button type="submit" class="admin-btn admin-btn--primary admin-btn--sm">Valider</button>
                                <button type="button" class="admin-btn admin-btn--outline admin-btn--sm"
                                        onclick="closeModal('mv-{{ $r->id }}')">Annuler</button>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
            @endif

            {{-- ── Modal : approuver le prêt ──────────────── --}}
            @if(in_array($r->status, ['validated','confirmed']))
            <tr class="ar-modal-row" id="ma-{{ $r->id }}" style="display:none;">
                <td colspan="7" style="padding:0;">
                    <div class="ar-inline-form ar-inline-form--success">
                        <strong class="ar-inline-form__title">Approuver le prêt de {{ $r->user->name ?? '' }}</strong>
                        <p style="font-size:12px;color:#718096;margin:4px 0 12px;">
                            Montant demandé : <strong>{{ number_format($r->amount, 0, ',', ' ') }} €</strong>
                            — {{ $r->duration_months }} mois
                        </p>
                        <form action="{{ route('admin.requests.approve', $r->id) }}" method="POST"
                              style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
                            @csrf
                            <div class="ar-field" style="min-width:160px;">
                                <label>Montant accordé (€) <span class="ar-req">*</span></label>
                                <input type="number" name="approved_amount" value="{{ $r->amount }}"
                                       min="1" required class="ar-input">
                            </div>
                            <div class="ar-field" style="flex:1;min-width:200px;">
                                <label>Note finale (optionnel)</label>
                                <input type="text" name="notes" class="ar-input" placeholder="Conditions particulières…">
                            </div>
                            <div style="display:flex;gap:6px;">
                                <button type="submit" class="admin-btn admin-btn--primary admin-btn--sm"
                                        style="background:#22c55e;border-color:#22c55e;">Approuver et créditer</button>
                                <button type="button" class="admin-btn admin-btn--outline admin-btn--sm"
                                        onclick="closeModal('ma-{{ $r->id }}')">Annuler</button>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
            @endif

            {{-- ── Modal : rejeter ────────────────────────── --}}
            @if(!in_array($r->status, ['approved','rejected']))
            <tr class="ar-modal-row" id="mr-{{ $r->id }}" style="display:none;">
                <td colspan="7" style="padding:0;">
                    <div class="ar-inline-form ar-inline-form--danger">
                        <strong class="ar-inline-form__title">Refuser la demande de {{ $r->user->name ?? '' }}</strong>
                        <form action="{{ route('admin.requests.reject', $r->id) }}" method="POST"
                              style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
                            @csrf
                            <div class="ar-field" style="flex:1;min-width:200px;">
                                <label>Motif du refus (optionnel)</label>
                                <input type="text" name="notes" class="ar-input"
                                       placeholder="Capacité d'emprunt insuffisante…">
                            </div>
                            <div style="display:flex;gap:6px;">
                                <button type="submit" class="admin-btn admin-btn--sm"
                                        style="background:#ef4444;border-color:#ef4444;color:#fff;">Confirmer le refus</button>
                                <button type="button" class="admin-btn admin-btn--outline admin-btn--sm"
                                        onclick="closeModal('mr-{{ $r->id }}')">Annuler</button>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
            @endif

            @empty
            <tr><td colspan="7" style="text-align:center;color:#718096;padding:40px;">Aucune demande trouvée</td></tr>
            @endforelse
        </tbody>
    </table>

    @if($requests->hasPages())
    <div class="admin-pagination">{{ $requests->links('pagination::simple-tailwind') }}</div>
    @endif
</div>

@endsection

@section('styles')
<style>
.admin-alert { display:flex;align-items:center;gap:10px;padding:13px 18px;border-radius:12px;font-size:14px;font-weight:600; }
.admin-alert--success { background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);color:#15803d; }
.admin-alert--error   { background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#dc2626; }

.ar-inline-form { padding:16px 24px;background:#f8faff;border-top:2px solid rgba(38,123,241,.15); }
.ar-inline-form--success { background:#f0fdf4;border-top-color:rgba(34,197,94,.3); }
.ar-inline-form--danger  { background:#fff5f5;border-top-color:rgba(239,68,68,.3); }
.ar-inline-form__title   { font-size:13px;font-weight:700;color:#1a2540;display:block;margin-bottom:8px; }

.ar-field { display:flex;flex-direction:column;gap:4px; }
.ar-field label { font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#4a5878; }
.ar-req { color:#ef4444; }
.ar-input,.ar-file { padding:8px 12px;border:2px solid rgba(38,123,241,.15);border-radius:8px;font-size:13px;outline:none;font-family:inherit;transition:border-color .2s; }
.ar-input:focus,.ar-file:focus { border-color:#267BF1; }

@media (max-width: 600px) {
    .ar-inline-form { padding:12px 14px; }
    .ar-inline-form form { flex-direction:column !important; }
    .ar-inline-form .ar-field { min-width:0 !important; width:100%; }
}
</style>
@endsection

@section('scripts')
<script>
function openModal(id) {
    var row = document.getElementById(id);
    if (row) row.style.display = '';
}
function closeModal(id) {
    var row = document.getElementById(id);
    if (row) row.style.display = 'none';
}
function adminConfirm(btn, msg) {
    if (confirm(msg)) btn.closest('form').submit();
}
</script>
@endsection
