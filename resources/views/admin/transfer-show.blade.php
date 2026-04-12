@extends('layouts.admin')
@section('title', 'Virement #' . str_pad($transfer->id, 5, '0', STR_PAD_LEFT))

@section('styles')
<style>
@keyframes spin { to { transform: rotate(360deg); } }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.5} }
.stop-level-row { display:flex; align-items:center; gap:8px; }
</style>
@endsection

@section('content')

<div style="display:grid;grid-template-columns:1fr 380px;gap:24px;align-items:start;">

    {{-- ── Panneau principal ────────────────────────────────── --}}
    <div>

        {{-- Détails du virement ────────────────────────────── --}}
        <div class="admin-card" style="margin-bottom:24px;">
            <div class="admin-card__header">
                <span class="admin-card__title">Détails du virement</span>
                @php
                    $cls = match($transfer->status) {
                        'pending'    => 'warning',
                        'processing' => 'info',
                        'completed'  => 'success',
                        'rejected'   => 'danger',
                        default      => 'muted',
                    };
                @endphp
                <span class="admin-badge admin-badge--{{ $cls }}">{{ $transfer->statusLabel() }}</span>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0;">
                @foreach([
                    ['Client',       $transfer->user->name . ' (' . $transfer->user->email . ')'],
                    ['Bénéficiaire', $transfer->recipient_name],
                    ['IBAN',         $transfer->recipient_iban],
                    ['BIC',          $transfer->recipient_bic ?: '—'],
                    ['Montant',      number_format($transfer->amount, 2, ',', ' ') . ' €'],
                    ['Motif',        $transfer->label ?: '—'],
                    ['Soumis le',    $transfer->created_at->format('d/m/Y à H:i')],
                    ['Note',         $transfer->note ?: '—'],
                ] as [$lbl, $val])
                <div style="padding:12px 24px;border-bottom:1px solid #f0f4ff;">
                    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:#8a9bb8;margin-bottom:3px;">{{ $lbl }}</div>
                    <div style="font-size:13px;font-weight:600;color:#1a2540;font-family:{{ in_array($lbl, ['IBAN','BIC']) ? 'monospace' : 'inherit' }};">{{ $val }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Progression (si approuvé avec avancement, en cours, en pause ou terminé) --}}
        @if(in_array($transfer->status, ['processing', 'paused', 'completed']) || ($transfer->status === 'approved' && $transfer->progress > 0))
        <div class="admin-card" style="margin-bottom:24px;">
            <div class="admin-card__header">
                <span class="admin-card__title">Progression</span>
                <span style="font-family:monospace;font-weight:700;color:#267BF1;">{{ $transfer->progress }}%</span>
            </div>
            <div style="padding:0 24px 16px;">
                <div style="height:10px;background:#f0f4ff;border-radius:5px;overflow:hidden;margin-bottom:6px;">
                    <div style="height:100%;width:{{ $transfer->progress }}%;background:{{ $transfer->status==='completed' ? '#15803d' : '#267BF1' }};border-radius:5px;transition:width 0.5s;"></div>
                </div>
            </div>

            {{-- Niveaux d'arrêt avec codes ────────────────────── --}}
            @if($transfer->sortedStopLevels())
            <div style="padding:0 24px 20px;display:flex;flex-direction:column;gap:10px;">
                @foreach($transfer->sortedStopLevels() as $lvl)
                @php
                    $reached   = !empty($lvl['reached_at']);
                    $hasCode   = !empty($lvl['unlock_code']);
                    $codeUsed  = !empty($lvl['code_used_at']);
                    $isPaused  = $hasCode && !$codeUsed;
                @endphp
                <div style="border-radius:10px;overflow:hidden;border:1px solid {{ $isPaused ? 'rgba(245,158,11,0.3)' : ($reached ? 'rgba(21,128,61,0.15)' : '#e5eaf5') }};background:{{ $isPaused ? 'rgba(245,158,11,0.04)' : ($reached ? 'rgba(21,128,61,0.04)' : '#f9fafc') }};">
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 14px;">
                        <div style="flex-shrink:0;width:36px;height:36px;border-radius:50%;background:{{ $isPaused ? 'rgba(245,158,11,0.12)' : ($reached ? 'rgba(21,128,61,0.12)' : 'rgba(38,123,241,0.08)') }};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:{{ $isPaused ? '#d97706' : ($reached ? '#15803d' : '#267BF1') }};">
                            {{ $lvl['percentage'] }}%
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:13px;font-weight:600;color:#1a2540;">Palier {{ $lvl['percentage'] }}%</div>
                            <div style="font-size:11px;color:#8a9bb8;margin-top:2px;">
                                @if($reached) Atteint le {{ \Carbon\Carbon::parse($lvl['reached_at'])->format('d/m/Y à H:i') }}
                                @else En attente
                                @endif
                            </div>
                        </div>
                        @if($codeUsed)
                            <span style="font-size:11px;font-weight:700;color:#15803d;background:rgba(21,128,61,0.1);padding:3px 10px;border-radius:20px;">Code utilisé</span>
                        @elseif($isPaused)
                            <span style="font-size:11px;font-weight:700;color:#d97706;background:rgba(245,158,11,0.1);padding:3px 10px;border-radius:20px;animation:pulse 2s infinite;">⏸ En pause</span>
                        @elseif($reached)
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#15803d" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        @endif
                    </div>

                    {{-- Code de déblocage ────────────────────── --}}
                    @if($hasCode)
                    <div style="padding:10px 14px;border-top:1px solid {{ $codeUsed ? 'rgba(21,128,61,0.1)' : 'rgba(245,158,11,0.15)' }};background:{{ $codeUsed ? 'rgba(21,128,61,0.03)' : 'rgba(245,158,11,0.06)' }};">
                        <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:{{ $codeUsed ? '#8a9bb8' : '#d97706' }};margin-bottom:6px;">Code de déblocage</div>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <code id="code-{{ $loop->index }}" style="font-family:monospace;font-size:20px;font-weight:900;letter-spacing:3px;color:{{ $codeUsed ? '#8a9bb8' : '#1a2540' }};background:{{ $codeUsed ? '#f5f7fa' : '#fff' }};padding:8px 16px;border-radius:8px;border:1px solid {{ $codeUsed ? '#e5eaf5' : '#dde3f0' }};text-decoration:{{ $codeUsed ? 'line-through' : 'none' }};">{{ $lvl['unlock_code'] }}</code>
                            @if(!$codeUsed)
                            <button onclick="navigator.clipboard.writeText('{{ $lvl['unlock_code'] }}');this.textContent='✓ Copié';setTimeout(()=>this.textContent='Copier',2000);"
                                    style="padding:8px 14px;background:#267BF1;color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;flex-shrink:0;">Copier</button>
                            @endif
                        </div>
                        @if($codeUsed)
                        <div style="font-size:11px;color:#8a9bb8;margin-top:6px;">Utilisé le {{ \Carbon\Carbon::parse($lvl['code_used_at'])->format('d/m/Y à H:i') }}</div>
                        @else
                        <div style="font-size:11px;color:#d97706;margin-top:6px;">⚠ À envoyer au client via la messagerie — usage unique</div>
                        @endif
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endif

    </div>

    {{-- ── Panneau action (droite) ───────────────────────────── --}}
    <div>
        @if($transfer->status === 'pending')

        <div class="admin-card">
            <div class="admin-card__header">
                <span class="admin-card__title">Validation & Niveaux d'arrêt</span>
            </div>

            @if($errors->any())
            <div style="margin:0 20px 16px;padding:12px 16px;background:rgba(239,68,68,0.06);border:1px solid rgba(239,68,68,0.2);border-radius:8px;font-size:13px;color:#dc2626;">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
            @endif

            <form action="{{ route('admin.transfers.validate', $transfer) }}" method="POST" id="validate-form">
                @csrf

                <div style="padding:0 20px 20px;">

                    {{-- Niveaux d'arrêt ──────────────────────── --}}
                    <div style="margin-bottom:20px;">
                        <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:#8a9bb8;margin-bottom:12px;">
                            Niveaux d'arrêt <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#c4cede;">(optionnels, max 10)</span>
                        </div>

                        <div id="levels-container" style="display:flex;flex-direction:column;gap:10px;">
                            @foreach(old('stop_levels', []) as $i => $lvl)
                            <div class="stop-level-row" data-index="{{ $i }}">
                                <input type="number" name="stop_levels[{{ $i }}][percentage]"
                                       value="{{ $lvl['percentage'] }}"
                                       min="1" max="99" placeholder="%"
                                       style="width:60px;padding:8px;border:1px solid #dde3f0;border-radius:6px;font-size:13px;font-family:monospace;text-align:center;">
                                <input type="text" name="stop_levels[{{ $i }}][text]"
                                       value="{{ $lvl['text'] }}"
                                       placeholder="Message affiché au client..."
                                       style="flex:1;padding:8px 10px;border:1px solid #dde3f0;border-radius:6px;font-size:13px;">
                                <button type="button" class="remove-level-btn" style="padding:6px;background:none;border:1px solid rgba(239,68,68,0.2);border-radius:6px;color:#ef4444;cursor:pointer;flex-shrink:0;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                </button>
                            </div>
                            @endforeach
                        </div>

                        <button type="button" id="add-level-btn"
                                style="margin-top:10px;width:100%;padding:8px;border:1px dashed #c4cede;border-radius:8px;background:none;color:#8a9bb8;font-size:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;font-family:inherit;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Ajouter un niveau d'arrêt
                        </button>
                    </div>

                    {{-- Message de fin obligatoire ────────────── --}}
                    <div style="padding-top:16px;border-top:1px solid #f0f4ff;">
                        <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:#1a2540;margin-bottom:8px;">
                            Message de fin (100 %) <span style="color:#ef4444;">*</span>
                        </label>
                        <textarea name="completion_message" rows="3" required
                                  placeholder="Votre virement a été exécuté avec succès. Les fonds seront disponibles sous 24h."
                                  style="width:100%;padding:10px 12px;border:1px solid #dde3f0;border-radius:8px;font-size:13px;font-family:inherit;resize:vertical;line-height:1.5;">{{ old('completion_message') }}</textarea>
                        <div style="font-size:11px;color:#8a9bb8;margin-top:4px;">Message obligatoire — affiché à 100% de progression</div>
                    </div>

                    {{-- Actions ──────────────────────────────── --}}
                    <div style="display:flex;flex-direction:column;gap:10px;margin-top:20px;">
                        <button type="submit" class="admin-btn admin-btn--primary" style="width:100%;justify-content:center;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Valider & lancer le virement
                        </button>
                    </div>
                </div>
            </form>

            <form action="{{ route('admin.transfers.reject', $transfer) }}" method="POST"
                  style="padding:0 20px 20px;">
                @csrf
                <button type="button" class="admin-btn admin-btn--danger" style="width:100%;justify-content:center;"
                        onclick="adminConfirm(this, 'Confirmer le rejet de ce virement ?')">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Rejeter ce virement
                </button>
            </form>
        </div>

        @elseif($transfer->status === 'approved')
        <div class="admin-card" style="border-color:rgba(38,123,241,0.2);">
            <div class="admin-card__header" style="background:rgba(38,123,241,0.04);">
                <span class="admin-card__title">En attente de reprise</span>
                <span style="font-size:12px;font-weight:700;color:#267BF1;background:rgba(38,123,241,0.1);padding:3px 10px;border-radius:20px;">{{ $transfer->progress }}% atteint</span>
            </div>
            <div style="padding:20px;font-size:13px;color:#475569;line-height:1.7;">
                <p>Le job d'exécution s'est interrompu (timeout ou erreur). Le virement a été remis en statut <strong>Approuvé</strong>.</p>
                <p style="margin-top:10px;">Le client voit le bouton <strong>« Reprendre le virement »</strong> sur son espace. Il peut relancer l'exécution à tout moment.</p>
                @if($transfer->progress > 0)
                <div style="margin-top:14px;padding:12px;background:#f1f5f9;border-radius:10px;font-size:12px;">
                    <strong>Progression conservée :</strong> {{ $transfer->progress }}% — le virement reprendra depuis ce point.
                </div>
                @endif
            </div>
        </div>

        @elseif($transfer->status === 'processing')
        <div class="admin-card">
            <div class="admin-card__header">
                <span class="admin-card__title">Exécution en cours</span>
            </div>
            <div style="padding:20px;text-align:center;color:#8a9bb8;font-size:13px;">
                <div style="width:48px;height:48px;border:3px solid rgba(38,123,241,0.15);border-top-color:#267BF1;border-radius:50%;animation:spin 1s linear infinite;margin:0 auto 16px;"></div>
                <p>Ce virement est en cours d'exécution.</p>
                <p style="margin-top:6px;font-size:12px;">Progression : <strong style="color:#267BF1;">{{ $transfer->progress }}%</strong></p>
                <p style="margin-top:4px;font-size:11px;">Validé le {{ $transfer->validated_at?->format('d/m/Y à H:i') }}</p>
            </div>
        </div>

        @elseif($transfer->status === 'paused')
        @php $activeLevel = $transfer->activePausedLevel(); @endphp
        <div class="admin-card" style="border-color:rgba(245,158,11,0.3);">
            <div class="admin-card__header" style="background:rgba(245,158,11,0.04);">
                <span class="admin-card__title">⏸ Virement en pause</span>
                <span style="font-size:12px;font-weight:700;color:#d97706;background:rgba(245,158,11,0.12);padding:3px 10px;border-radius:20px;animation:pulse 2s infinite;">{{ $transfer->progress }}% atteint</span>
            </div>
            <div style="padding:20px;">
                <p style="font-size:13px;color:#64748b;margin-bottom:20px;line-height:1.6;">
                    Le client doit entrer le code de déblocage pour continuer.
                    Copiez le code ci-dessous et transmettez-le via la messagerie.
                </p>

                @if($activeLevel)
                <div style="background:#fffbeb;border:1.5px solid rgba(245,158,11,0.3);border-radius:12px;padding:16px;">
                    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#d97706;margin-bottom:10px;">Code de déblocage actif</div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <code id="admin-active-code" style="font-family:monospace;font-size:24px;font-weight:900;letter-spacing:4px;color:#1a2540;background:#fff;padding:10px 18px;border-radius:8px;border:1px solid rgba(245,158,11,0.25);flex:1;text-align:center;">{{ $activeLevel['unlock_code'] }}</code>
                        <button onclick="navigator.clipboard.writeText('{{ $activeLevel['unlock_code'] }}');this.textContent='✓ Copié';this.style.background='#15803d';setTimeout(()=>{this.textContent='Copier';this.style.background='#267BF1';},2500);"
                                style="padding:10px 16px;background:#267BF1;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;flex-shrink:0;transition:background .2s;">Copier</button>
                    </div>
                    <div style="font-size:11px;color:#d97706;margin-top:8px;display:flex;align-items:center;gap:5px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Code unique — valable une seule fois
                    </div>
                </div>

                <form action="{{ route('admin.transfers.send-code', $transfer) }}" method="POST" style="margin-top:14px;">
                    @csrf
                    <button type="submit"
                            style="width:100%;display:flex;align-items:center;justify-content:center;gap:8px;padding:12px;background:#267BF1;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;transition:opacity .15s;"
                            onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/></svg>
                        Envoyer le code au client
                    </button>
                </form>
                @else
                <div style="text-align:center;color:#8a9bb8;font-size:13px;">
                    <p>Aucun code actif — le déblocage a peut-être déjà eu lieu.</p>
                </div>
                @endif
            </div>
        </div>

        @elseif($transfer->status === 'completed')
        <div class="admin-card">
            <div class="admin-card__header">
                <span class="admin-card__title">Virement terminé</span>
            </div>
            <div style="padding:20px;text-align:center;">
                <div style="width:48px;height:48px;border-radius:50%;background:rgba(21,128,61,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#15803d" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <p style="font-size:14px;font-weight:700;color:#15803d;">Exécuté avec succès</p>
                <p style="font-size:12px;color:#8a9bb8;margin-top:4px;">Terminé le {{ $transfer->completed_at?->format('d/m/Y à H:i') }}</p>
            </div>
        </div>

        @elseif($transfer->status === 'rejected')
        <div class="admin-card">
            <div class="admin-card__header">
                <span class="admin-card__title">Virement rejeté</span>
            </div>
            <div style="padding:20px;text-align:center;">
                <div style="width:48px;height:48px;border-radius:50%;background:rgba(239,68,68,0.08);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </div>
                <p style="font-size:14px;font-weight:700;color:#dc2626;">Rejeté</p>
            </div>
        </div>
        @endif

        <a href="{{ route('admin.transfers') }}" style="display:flex;align-items:center;gap:6px;margin-top:14px;font-size:13px;color:#8a9bb8;text-decoration:none;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Retour aux virements
        </a>
    </div>
</div>

@if($transfer->status === 'pending')
<script>
(function () {
    const container = document.getElementById('levels-container');
    const addBtn    = document.getElementById('add-level-btn');
    let count = container.querySelectorAll('.stop-level-row').length;

    function addRow() {
        if (count >= 10) { addBtn.disabled = true; return; }
        const row = document.createElement('div');
        row.className = 'stop-level-row';
        row.dataset.index = count;
        row.innerHTML = `
            <input type="number" name="stop_levels[${count}][percentage]"
                   min="1" max="99" placeholder="%" required
                   style="width:60px;padding:8px;border:1px solid #dde3f0;border-radius:6px;font-size:13px;font-family:monospace;text-align:center;">
            <input type="text" name="stop_levels[${count}][text]"
                   placeholder="Message affiché au client..." required
                   style="flex:1;padding:8px 10px;border:1px solid #dde3f0;border-radius:6px;font-size:13px;">
            <button type="button" class="remove-level-btn"
                    style="padding:6px;background:none;border:1px solid rgba(239,68,68,0.2);border-radius:6px;color:#ef4444;cursor:pointer;flex-shrink:0;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>`;
        container.appendChild(row);
        count++;
        if (count >= 10) addBtn.disabled = true;
        bindRemove(row.querySelector('.remove-level-btn'));
    }

    function bindRemove(btn) {
        btn.addEventListener('click', function () {
            btn.closest('.stop-level-row').remove();
            count--;
            addBtn.disabled = false;
            // Ré-indexer
            container.querySelectorAll('.stop-level-row').forEach((r, i) => {
                r.querySelectorAll('input').forEach(inp => {
                    inp.name = inp.name.replace(/\[\d+\]/, '[' + i + ']');
                });
            });
        });
    }

    // Bind remove sur les lignes déjà présentes (old input)
    container.querySelectorAll('.remove-level-btn').forEach(bindRemove);
    addBtn.addEventListener('click', addRow);
})();
</script>
@endif

@endsection
