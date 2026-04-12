@extends('layouts.admin')
@section('title', 'Prêts actifs')

@section('content')

{{-- Formulaire création prêt --}}
<div class="admin-card" style="margin-bottom:24px;">
    <div class="admin-card__header">
        <span class="admin-card__title">Ajouter un prêt</span>
        <button onclick="document.getElementById('loan-form').classList.toggle('hidden')" class="admin-btn admin-btn--outline admin-btn--sm">+ Nouveau</button>
    </div>
    <div id="loan-form" class="hidden" style="padding:20px 24px;border-top:1px solid rgba(38,123,241,0.06);">
        <form action="{{ route('admin.loans.create') }}" method="POST">
            @csrf
            <div class="loan-form-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:14px;">
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:4px;">Client</label>
                    <select name="user_id" required style="width:100%;padding:8px 12px;border:1.5px solid rgba(38,123,241,0.15);border-radius:8px;font-size:13px;box-sizing:border-box;outline:none;background:#fff;cursor:pointer;">
                        <option value="" disabled selected>— Sélectionner un client —</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:4px;">Type</label>
                    <select name="type" style="width:100%;padding:8px 12px;border:1.5px solid rgba(38,123,241,0.15);border-radius:8px;font-size:13px;box-sizing:border-box;outline:none;">
                        <option value="immobilier">Immobilier</option>
                        <option value="automobile">Automobile</option>
                        <option value="personnel">Personnel</option>
                        <option value="entreprise">Entreprise</option>
                        <option value="agricole">Agricole</option>
                        <option value="microcredit">Microcrédit</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:4px;">Statut</label>
                    <select name="status" style="width:100%;padding:8px 12px;border:1.5px solid rgba(38,123,241,0.15);border-radius:8px;font-size:13px;box-sizing:border-box;outline:none;">
                        <option value="active">Actif</option>
                        <option value="closed">Clôturé</option>
                        <option value="late">En retard</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:4px;">Montant (€)</label>
                    <input type="number" name="amount" placeholder="200000" required style="width:100%;padding:8px 12px;border:1.5px solid rgba(38,123,241,0.15);border-radius:8px;font-size:13px;box-sizing:border-box;outline:none;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:4px;">Capital restant (€)</label>
                    <input type="number" name="remaining" placeholder="150000" required style="width:100%;padding:8px 12px;border:1.5px solid rgba(38,123,241,0.15);border-radius:8px;font-size:13px;box-sizing:border-box;outline:none;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:4px;">Mensualité (€)</label>
                    <input type="number" name="monthly" placeholder="850" required style="width:100%;padding:8px 12px;border:1.5px solid rgba(38,123,241,0.15);border-radius:8px;font-size:13px;box-sizing:border-box;outline:none;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:4px;">Taux (%)</label>
                    <input type="number" step="0.01" name="rate" placeholder="2.50" required style="width:100%;padding:8px 12px;border:1.5px solid rgba(38,123,241,0.15);border-radius:8px;font-size:13px;box-sizing:border-box;outline:none;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:4px;">Date début</label>
                    <input type="date" name="start_date" required style="width:100%;padding:8px 12px;border:1.5px solid rgba(38,123,241,0.15);border-radius:8px;font-size:13px;box-sizing:border-box;outline:none;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:4px;">Date fin</label>
                    <input type="date" name="end_date" required style="width:100%;padding:8px 12px;border:1.5px solid rgba(38,123,241,0.15);border-radius:8px;font-size:13px;box-sizing:border-box;outline:none;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:4px;">Progression (%)</label>
                    <input type="number" name="progress" min="0" max="100" placeholder="25" value="0" required style="width:100%;padding:8px 12px;border:1.5px solid rgba(38,123,241,0.15);border-radius:8px;font-size:13px;box-sizing:border-box;outline:none;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#718096;display:block;margin-bottom:4px;">Prochain paiement</label>
                    <input type="date" name="next_payment_date" style="width:100%;padding:8px 12px;border:1.5px solid rgba(38,123,241,0.15);border-radius:8px;font-size:13px;box-sizing:border-box;outline:none;">
                </div>
            </div>
            <button type="submit" class="admin-btn admin-btn--primary">Créer le prêt</button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card__header">
        <span class="admin-card__title">Liste des prêts</span>
        <span style="font-size:12px;color:#718096;">{{ $loans->total() }} prêt(s)</span>
    </div>
    <table class="admin-table admin-table--wide">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Type</th>
                <th>Montant</th>
                <th>Restant</th>
                <th>Mensualité</th>
                <th>Taux</th>
                <th>Progression</th>
                <th>Statut</th>
                <th>Modifier</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $l)
            <tr>
                <td style="color:#718096;font-size:11px;font-family:var(--font-mono);">#{{ $l->id }}</td>
                <td>
                    <div class="admin-user-chip">
                        <div class="admin-user-chip__av">{{ strtoupper(substr($l->user->name ?? 'U', 0, 2)) }}</div>
                        <div>
                            <div class="admin-user-chip__name">{{ $l->user->name ?? '—' }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $l->typeLabel() }}</td>
                <td style="font-family:var(--font-mono);font-weight:700;">{{ number_format($l->amount, 0, ',', ' ') }} €</td>
                <td style="font-family:var(--font-mono);">{{ number_format($l->remaining, 0, ',', ' ') }} €</td>
                <td style="font-family:var(--font-mono);">{{ number_format($l->monthly, 0, ',', ' ') }} €</td>
                <td>{{ $l->rate }} %</td>
                <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:60px;height:6px;background:rgba(38,123,241,0.1);border-radius:3px;overflow:hidden;">
                            <div style="width:{{ $l->progress }}%;height:100%;background:#267BF1;border-radius:3px;"></div>
                        </div>
                        <span style="font-size:11px;color:#718096;">{{ $l->progress }}%</span>
                    </div>
                </td>
                <td><span class="admin-badge admin-badge--{{ $l->status }}">{{ $l->statusLabel() }}</span></td>
                <td style="white-space:nowrap;">
                    <button onclick="openLoanModal({{ $l->id }}, {{ $l->remaining }}, {{ $l->monthly }}, {{ $l->progress }}, '{{ $l->status }}', '{{ $l->next_payment_date?->format('Y-m-d') ?? '' }}')"
                            class="admin-btn admin-btn--outline admin-btn--sm" style="gap:5px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Modifier
                    </button>
                    <form action="{{ route('admin.loans.delete', $l->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="button" class="admin-btn admin-btn--danger admin-btn--sm" title="Supprimer"
                                onclick="adminConfirm(this, 'Supprimer le prêt #{{ $l->id }} de {{ addslashes($l->user->name ?? '') }} ?')">✕</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="10" style="text-align:center;color:#718096;padding:32px;">Aucun prêt enregistré</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($loans->hasPages())
    <div class="admin-pagination">{{ $loans->links('pagination::simple-tailwind') }}</div>
    @endif
</div>

{{-- ── Modal édition prêt ────────────────────────────────────── --}}
<div id="loan-edit-overlay" class="leo" onclick="if(event.target===this)closeLoanModal()">
    <div class="leo__box">
        <div class="leo__header">
            <span class="leo__title">Modifier le prêt <span id="modal-loan-id" class="leo__id"></span></span>
            <button onclick="closeLoanModal()" class="leo__close">×</button>
        </div>
        <form id="loan-edit-form" method="POST">
            @csrf
            <div class="loan-modal-grid leo__body">
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;display:block;margin-bottom:5px;">Capital restant (€)</label>
                    <input id="modal-remaining" type="number" name="remaining" min="0" required
                           style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;font-weight:600;box-sizing:border-box;outline:none;transition:border-color .15s;"
                           onfocus="this.style.borderColor='#267BF1'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;display:block;margin-bottom:5px;">Mensualité (€)</label>
                    <input id="modal-monthly" type="number" name="monthly" min="1" required
                           style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;font-weight:600;box-sizing:border-box;outline:none;transition:border-color .15s;"
                           onfocus="this.style.borderColor='#267BF1'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;display:block;margin-bottom:5px;">Progression (%)</label>
                    <div style="position:relative;">
                        <input id="modal-progress" type="number" name="progress" min="0" max="100" required
                               oninput="document.getElementById('progress-bar-preview').style.width=Math.min(100,Math.max(0,this.value))+'%';document.getElementById('progress-val').textContent=this.value+'%';"
                               style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;font-weight:600;box-sizing:border-box;outline:none;transition:border-color .15s;"
                               onfocus="this.style.borderColor='#267BF1'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                    <div style="margin-top:6px;height:6px;background:#eef2f9;border-radius:3px;overflow:hidden;">
                        <div id="progress-bar-preview" style="height:100%;background:#267BF1;border-radius:3px;transition:width .2s;width:0%;"></div>
                    </div>
                    <div id="progress-val" style="font-size:11px;color:#267BF1;font-weight:700;margin-top:3px;text-align:right;">0%</div>
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;display:block;margin-bottom:5px;">Statut</label>
                    <select id="modal-status" name="status"
                            style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;font-weight:600;box-sizing:border-box;outline:none;background:#fff;cursor:pointer;transition:border-color .15s;"
                            onfocus="this.style.borderColor='#267BF1'" onblur="this.style.borderColor='#e2e8f0'">
                        <option value="active">Actif</option>
                        <option value="closed">Clôturé</option>
                        <option value="late">En retard</option>
                    </select>
                </div>
                <div style="grid-column:1/-1;">
                    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;display:block;margin-bottom:5px;">Prochain paiement</label>
                    <input id="modal-next-payment" type="date" name="next_payment_date"
                           style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;box-sizing:border-box;outline:none;transition:border-color .15s;"
                           onfocus="this.style.borderColor='#267BF1'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
            </div>
            <div class="leo__footer">
                <button type="button" onclick="closeLoanModal()" class="leo__cancel">Annuler</button>
                <button type="submit" class="leo__submit">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

@section('styles')
<style>
.hidden { display: none !important; }

/* ── Loan edit overlay ─────────────────────────────────── */
.leo {
    position: fixed; inset: 0; z-index: 9000;
    display: flex; align-items: center; justify-content: center; padding: 20px;
    background: rgba(15,23,42,.55);
    opacity: 0; visibility: hidden; pointer-events: none;
    transition: opacity .15s, visibility .15s;
    will-change: opacity;
}
.leo.open { opacity: 1; visibility: visible; pointer-events: auto; }
.leo__box {
    background: #fff; border-radius: 20px; width: 100%; max-width: 500px;
    box-shadow: 0 24px 64px rgba(15,23,42,.18); overflow: hidden;
    will-change: transform, opacity;
}
.leo.open .leo__box { animation: leo-slide .15s ease-out; }
@keyframes leo-slide { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
.leo__header {
    padding: 20px 24px 16px; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
}
.leo__title { font-size: 16px; font-weight: 800; color: #0f172a; }
.leo__id    { color: #267BF1; font-family: monospace; }
.leo__close { background: none; border: none; cursor: pointer; color: #94a3b8; font-size: 22px; line-height: 1; padding: 0; }
.leo__close:hover { color: #475569; }
.leo__body  { padding: 20px 24px; display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.leo__footer {
    padding: 16px 24px; border-top: 1px solid #f1f5f9;
    display: flex; gap: 10px; justify-content: flex-end; background: #f8fafc;
}
.leo__cancel {
    padding: 10px 20px; background: #f1f5f9; color: #475569;
    border: none; border-radius: 10px; font-size: 14px; font-weight: 600;
    cursor: pointer; font-family: inherit;
}
.leo__cancel:hover { background: #e2e8f0; }
.leo__submit {
    padding: 10px 24px; background: linear-gradient(135deg,#267BF1,#1a56db);
    color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 700;
    cursor: pointer; display: flex; align-items: center; gap: 8px; font-family: inherit;
}
.leo__submit:hover { opacity: .9; }

/* ── Form grid responsive ──────────────────────────────── */
@media (max-width: 900px) {
    .loan-form-grid { grid-template-columns: repeat(2, 1fr) !important; }
}
@media (max-width: 560px) {
    .loan-form-grid { grid-template-columns: 1fr !important; }
    .leo__body      { grid-template-columns: 1fr !important; }
    .leo__box       { border-radius: 16px; }
    .leo            { padding: 12px; }
}
</style>
@endsection

@section('scripts')
<script>
function openLoanModal(id, remaining, monthly, progress, status, nextPayment) {
    document.getElementById('modal-loan-id').textContent = '#' + String(id).padStart(4, '0');
    document.getElementById('loan-edit-form').action = '/admin/prets/' + id;
    document.getElementById('modal-remaining').value   = remaining;
    document.getElementById('modal-monthly').value     = monthly;
    document.getElementById('modal-progress').value    = progress;
    document.getElementById('modal-status').value      = status;
    document.getElementById('modal-next-payment').value = nextPayment || '';

    // Barre de prévisualisation
    document.getElementById('progress-bar-preview').style.width = progress + '%';
    document.getElementById('progress-val').textContent = progress + '%';

    document.getElementById('loan-edit-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeLoanModal() {
    document.getElementById('loan-edit-overlay').classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeLoanModal(); });
</script>
@endsection
