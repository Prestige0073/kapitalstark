@extends('layouts.dashboard')
@section('title', __('dashboard.transfers.detail_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/transfer.css') }}">
<style>
/* ── Layout ──────────────────────────────────────────────── */
.transfer-show-wrap { display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start; }
@media(max-width:900px){ .transfer-show-wrap { grid-template-columns: 1fr; } }

/* ── Progress card ───────────────────────────────────────── */
.tpcard { background:#fff; border-radius:20px; border:1px solid #f1f5f9; box-shadow:0 2px 16px rgba(26,37,64,.06); overflow:hidden; }
.tpcard__body { padding: 40px 48px; }
@media(max-width:600px){ .tpcard__body { padding: 28px 20px; } }
@media(max-width:480px){ .tpcard__body { padding: 20px 14px; } }

/* État approved : bouton lancer */
.tpcard__launch { padding: 32px 48px; border-top: 1px solid #f1f5f9; text-align: center; }
@media(max-width:600px){ .tpcard__launch { padding: 24px 20px; } }
@media(max-width:480px){ .tpcard__launch { padding: 18px 14px; } }
.launch-hint { font-size: 13px; color: #94a3b8; margin-bottom: 20px; }
.launch-btn { display: inline-flex; align-items: center; gap: 10px; padding: 16px 40px; background: linear-gradient(135deg,#267BF1,#1a56db); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 800; cursor: pointer; letter-spacing: -.2px; transition: opacity .15s; }
@media(max-width:480px){ .launch-btn { width: 100%; justify-content: center; padding: 14px 20px; font-size: 14px; border-radius: 12px; } }
.launch-btn:hover { opacity: .88; }
.launch-btn svg { flex-shrink: 0; }

/* ── Progress bar ─────────────────────────────────────────── */
.tp-bar-wrap { position: relative; margin-bottom: 18px; }
.tp-bar-track { height: 14px; background: #eef2f9; border-radius: 999px; overflow: hidden; }
.tp-bar-fill  { height: 100%; border-radius: 999px; background: linear-gradient(90deg,#267BF1,#1a56db); transition: width 5s linear; }
.tp-bar-fill--done { background: linear-gradient(90deg,#059669,#047857); transition: width .4s ease; }

/* Badge % flottant sur la barre */
.tp-pct-badge {
  position: absolute;
  top: -34px;
  background: #267BF1;
  color: #fff;
  font-size: 12px;
  font-weight: 800;
  padding: 4px 9px;
  border-radius: 8px;
  letter-spacing: -.2px;
  transform: translateX(-50%);
  transition: left .6s cubic-bezier(.4,0,.2,1);
  pointer-events: none;
  white-space: nowrap;
}
.tp-pct-badge::after {
  content: '';
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%);
  border: 5px solid transparent;
  border-top-color: #267BF1;
}
.tp-pct-badge--done { background: #059669; }
.tp-pct-badge--done::after { border-top-color: #059669; }

.tp-bar-ends { display: flex; justify-content: space-between; font-size: 12px; color: #94a3b8; margin-top: 4px; }

/* Statut texte discret */
.tp-status-line { text-align: center; font-size: 13px; color: #94a3b8; margin-top: 24px; }
.tp-status-line--done { color: #047857; font-weight: 600; }

/* ── Modal déblocage ──────────────────────────────────────── */
.unlock-overlay {
  position: fixed; inset: 0; z-index: 9000;
  background: rgba(15,23,42,.55);
  display: flex; align-items: center; justify-content: center;
  padding: 20px;
  opacity: 0; pointer-events: none;
  transition: opacity .22s;
}
.unlock-overlay.is-open { opacity: 1; pointer-events: auto; }
.unlock-modal {
  background: #fff;
  border-radius: 24px;
  padding: 40px 36px 32px;
  width: 100%; max-width: 420px;
  box-shadow: 0 24px 64px rgba(15,23,42,.18);
  transform: translateY(20px);
  transition: transform .25s cubic-bezier(.34,1.56,.64,1);
}
.unlock-overlay.is-open .unlock-modal { transform: translateY(0); }
.unlock-modal__icon {
  width: 56px; height: 56px; border-radius: 16px;
  background: #fef9c3; display: flex; align-items: center; justify-content: center;
  margin: 0 auto 20px;
}
.unlock-modal__title { text-align: center; font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
.unlock-modal__sub   { text-align: center; font-size: 13px; color: #64748b; margin-bottom: 28px; line-height: 1.5; }
.unlock-code-input {
  width: 100%; padding: 14px 16px;
  border: 2px solid #e2e8f0; border-radius: 12px;
  font-size: 20px; font-weight: 700; letter-spacing: 4px;
  text-align: center; text-transform: uppercase;
  color: #0f172a; background: #f8fafc;
  transition: border-color .15s;
  box-sizing: border-box;
}
.unlock-code-input:focus { outline: none; border-color: #267BF1; background: #fff; }
.unlock-code-input.is-error { border-color: #dc2626; }
.unlock-code-error { color: #dc2626; font-size: 12px; text-align: center; margin-top: 8px; min-height: 18px; }
.unlock-modal__actions { display: flex; flex-direction: column; gap: 10px; margin-top: 20px; }
.unlock-submit-btn {
  width: 100%; padding: 14px;
  background: linear-gradient(135deg,#267BF1,#1a56db);
  color: #fff; border: none; border-radius: 12px;
  font-size: 15px; font-weight: 800; cursor: pointer;
  transition: opacity .15s;
}
.unlock-submit-btn:hover { opacity: .88; }
.unlock-submit-btn:disabled { opacity: .5; cursor: not-allowed; }
.unlock-contact-btn {
  width: 100%; padding: 13px;
  background: #f1f5f9; color: #475569;
  border: none; border-radius: 12px;
  font-size: 14px; font-weight: 600; cursor: pointer;
  text-decoration: none; display: block; text-align: center;
  transition: background .15s;
}
.unlock-contact-btn:hover { background: #e2e8f0; color: #334155; }

.unlock-modal__level-text {
  background: #f0f9ff;
  border: 1px solid #bae6fd;
  border-radius: 10px;
  padding: 12px 16px;
  font-size: 13px;
  line-height: 1.6;
  color: #0369a1;
  margin-bottom: 16px;
  text-align: center;
}

.tp-completion-msg {
  text-align: center;
  font-size: 14px;
  line-height: 1.7;
  color: #047857;
  font-weight: 600;
  background: rgba(5,150,105,.06);
  border: 1px solid rgba(5,150,105,.2);
  border-radius: 12px;
  padding: 14px 20px;
  margin-top: 20px;
}

@media(max-width:480px){
  .unlock-modal { padding: 24px 18px; }
  .unlock-modal__title { font-size: 15px; }
  .unlock-code-input { font-size: 20px; letter-spacing: 6px; padding: 14px; }
  .unlock-submit-btn { font-size: 14px; }
}
</style>
@endsection

@section('content')
<div class="transfer-show-wrap">

    {{-- ── Carte progression ────────────────────────────────── --}}
    <div class="tpcard">
        <div class="tpcard__body">

            @if($transfer->status === 'pending')
            {{-- En attente admin ─────────────────────────── --}}
            <div class="tp-bar-wrap" style="margin-top:52px;">
                <div class="tp-pct-badge" style="left:0%;">0%</div>
                <div class="tp-bar-track">
                    <div class="tp-bar-fill" style="width:0%;"></div>
                </div>
                <div class="tp-bar-ends"><span>0%</span><span>100%</span></div>
            </div>
            <p class="tp-status-line">{{ __('dashboard.transfers.status_pending') }}</p>

            @elseif($transfer->status === 'approved')
            {{-- Approuvé, en attente du clic ─────────────── --}}
            <div class="tp-bar-wrap" style="margin-top:52px;">
                <div class="tp-pct-badge" style="left:0%;">0%</div>
                <div class="tp-bar-track">
                    <div class="tp-bar-fill" style="width:0%;"></div>
                </div>
                <div class="tp-bar-ends"><span>0%</span><span>100%</span></div>
            </div>

            @elseif($transfer->status === 'processing')
            {{-- En cours ─────────────────────────────────── --}}
            @php $pct = $transfer->progress; @endphp
            <div class="tp-bar-wrap" style="margin-top:52px;" id="bar-wrap">
                <div class="tp-pct-badge" id="pct-badge" style="left:{{ max(4, $pct) }}%;">{{ $pct }}%</div>
                <div class="tp-bar-track">
                    <div class="tp-bar-fill" id="bar-fill" style="width:{{ $pct }}%;"></div>
                </div>
                <div class="tp-bar-ends"><span>0%</span><span>100%</span></div>
            </div>
            <p class="tp-status-line" id="status-line">{{ str_replace(':n', $pct, __('dashboard.transfers.pct_completed')) }}</p>

            @elseif($transfer->status === 'completed')
            {{-- Terminé ──────────────────────────────────── --}}
            <div class="tp-bar-wrap" style="margin-top:52px;">
                <div class="tp-pct-badge tp-pct-badge--done" style="left:96%;">100%</div>
                <div class="tp-bar-track">
                    <div class="tp-bar-fill tp-bar-fill--done" style="width:100%;"></div>
                </div>
                <div class="tp-bar-ends"><span>0%</span><span>100%</span></div>
            </div>
            @if($transfer->completion_message)
            <p class="tp-completion-msg">{{ $transfer->completion_message }}</p>
            @else
            <p class="tp-status-line tp-status-line--done">{{ __('dashboard.transfers.status_completed') }}</p>
            @endif

            @elseif($transfer->status === 'paused')
            {{-- En pause (attente code de déblocage) ────────── --}}
            @php $pct = $transfer->progress; @endphp
            <div class="tp-bar-wrap" style="margin-top:52px;" id="bar-wrap">
                <div class="tp-pct-badge" id="pct-badge" style="left:{{ max(4, min(96, $pct)) }}%;">{{ $pct }}%</div>
                <div class="tp-bar-track">
                    <div class="tp-bar-fill" id="bar-fill" style="width:{{ $pct }}%;transition:none;"></div>
                </div>
                <div class="tp-bar-ends"><span>0%</span><span>100%</span></div>
            </div>

            @elseif($transfer->status === 'rejected')
            <div class="tp-bar-wrap" style="margin-top:52px;">
                <div class="tp-pct-badge" style="left:0%;background:#dc2626;">0%</div>
                <div class="tp-bar-track"><div class="tp-bar-fill" style="width:0%;background:#dc2626;"></div></div>
                <div class="tp-bar-ends"><span>0%</span><span>100%</span></div>
            </div>
            <p class="tp-status-line" style="color:#dc2626;">{{ __('dashboard.transfers.status_rejected') }}</p>
            @endif

        </div>

        {{-- Bouton lancer / reprendre (approved only) ───────── --}}
        @if($transfer->status === 'approved')
        <div class="tpcard__launch">
            @if($transfer->progress > 0)
            <p class="launch-hint">{{ __('dashboard.transfers.resume_hint') }}</p>
            @else
            <p class="launch-hint">{{ __('dashboard.transfers.launch_hint') }}</p>
            @endif
            <form method="POST" action="{{ route('dashboard.transfers.execute', $transfer) }}"
                  onsubmit="this.querySelector('button').disabled=true;this.querySelector('button').textContent='{{ __('dashboard.transfers.launching') }}';">
                @csrf
                <button type="submit" class="launch-btn">
                    @if($transfer->progress > 0)
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.86"/></svg>
                    {{ __('dashboard.transfers.resume_btn') }}
                    @else
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    {{ __('dashboard.transfers.launch_btn') }}
                    @endif
                </button>
            </form>
        </div>
        @endif

        @if($transfer->status === 'completed')
        <div class="tpcard__launch">
            <a href="{{ route('dashboard.transfers.receipt', $transfer) }}"
               style="display:inline-flex;align-items:center;gap:8px;padding:14px 32px;background:#059669;color:#fff;border-radius:12px;font-size:14px;font-weight:700;text-decoration:none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                {{ __('dashboard.transfers.download_receipt') }}
            </a>
        </div>
        @endif
    </div>

    {{-- ── Récapitulatif ────────────────────────────────────── --}}
    <div class="transfer-detail-panel">
        <div class="dash-card">
            <div class="dash-card__header">
                <h3 class="dash-card__title">{{ __('dashboard.transfers.detail_title') }}</h3>
            </div>
            <div class="transfer-detail-rows">
                <div class="transfer-detail-row">
                    <span class="transfer-detail-label">{{ __('dashboard.transfers.detail_ref') }}</span>
                    <span class="transfer-detail-value transfer-detail-value--mono">#{{ str_pad($transfer->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="transfer-detail-row">
                    <span class="transfer-detail-label">{{ __('dashboard.transfers.detail_amount') }}</span>
                    <span class="transfer-detail-value transfer-detail-value--amount">{{ number_format($transfer->amount, 2, ',', ' ') }} €</span>
                </div>
                <div class="transfer-detail-row">
                    <span class="transfer-detail-label">{{ __('dashboard.transfers.detail_recipient') }}</span>
                    <span class="transfer-detail-value">{{ $transfer->recipient_name }}</span>
                </div>
                <div class="transfer-detail-row">
                    <span class="transfer-detail-label">{{ __('dashboard.transfers.detail_iban') }}</span>
                    <span class="transfer-detail-value transfer-detail-value--mono">{{ $transfer->recipient_iban }}</span>
                </div>
                @if($transfer->recipient_bic)
                <div class="transfer-detail-row">
                    <span class="transfer-detail-label">{{ __('dashboard.transfers.detail_bic') }}</span>
                    <span class="transfer-detail-value transfer-detail-value--mono">{{ $transfer->recipient_bic }}</span>
                </div>
                @endif
                @if($transfer->label)
                <div class="transfer-detail-row">
                    <span class="transfer-detail-label">{{ __('dashboard.transfers.detail_label') }}</span>
                    <span class="transfer-detail-value">{{ $transfer->label }}</span>
                </div>
                @endif
                <div class="transfer-detail-row">
                    <span class="transfer-detail-label">{{ __('dashboard.transfers.detail_date') }}</span>
                    <span class="transfer-detail-value">{{ $transfer->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                <div class="transfer-detail-row">
                    <span class="transfer-detail-label">{{ __('dashboard.transfers.detail_fees') }}</span>
                    <span class="transfer-detail-value" style="color:#15803d;font-weight:700;">{{ __('dashboard.transfers.detail_fees_free') }}</span>
                </div>
                <div class="transfer-detail-row">
                    <span class="transfer-detail-label">{{ __('dashboard.transfers.detail_status') }}</span>
                    <span class="transfer-status-badge transfer-status-badge--{{ $transfer->statusClass() }}">{{ $transfer->statusLabel() }}</span>
                </div>
            </div>
        </div>

        <a href="{{ route('dashboard.transfers.index') }}" class="transfer-back-link" style="margin-top:12px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            {{ __('dashboard.transfers.back_link') }}
        </a>
    </div>

</div>

{{-- ── Modal de déblocage ──────────────────────────────────── --}}
<div class="unlock-overlay" id="unlock-overlay" role="dialog" aria-modal="true" aria-labelledby="unlock-modal-title">
    <div class="unlock-modal">
        <div class="unlock-modal__icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ca8a04" stroke-width="2.2" aria-hidden="true">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 9.9-1"/>
            </svg>
        </div>
        <h2 class="unlock-modal__title" id="unlock-modal-title">{{ __('dashboard.transfers.unlock_title') }}</h2>
        @if($transfer->status === 'paused' && $transfer->currentLevelText())
        <p class="unlock-modal__level-text" id="unlock-level-text">{{ $transfer->currentLevelText() }}</p>
        @else
        <p class="unlock-modal__level-text" id="unlock-level-text" style="display:none;"></p>
        @endif
        <p class="unlock-modal__sub">
            {!! nl2br(e(__('dashboard.transfers.unlock_sub'))) !!}
        </p>
        <form method="POST" action="{{ route('dashboard.transfers.unlock', $transfer) }}" id="unlock-form">
            @csrf
            <input
                type="text"
                name="code"
                id="unlock-code-input"
                class="unlock-code-input{{ $errors->has('code') ? ' is-error' : '' }}"
                placeholder="XXX-XXXX"
                maxlength="8"
                autocomplete="off"
                spellcheck="false"
                value="{{ old('code') }}"
            >
            <p class="unlock-code-error" id="unlock-code-error">
                @error('code'){{ $message }}@enderror
            </p>
            <div class="unlock-modal__actions">
                <button type="submit" class="unlock-submit-btn" id="unlock-submit-btn">
                    {{ __('dashboard.transfers.unlock_btn') }}
                </button>
                <a href="{{ route('dashboard.messages') }}" class="unlock-contact-btn">
                    {{ __('dashboard.transfers.unlock_contact') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
{{-- Modal : auto-open si status=paused ou erreur de code --}}
@if($transfer->status === 'paused' || $errors->has('code'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('unlock-overlay').classList.add('is-open');
    document.getElementById('unlock-code-input').focus();
});
</script>
@endif

@if($transfer->status === 'processing' || $transfer->status === 'paused')
<script>
(function () {
    'use strict';

    // ── URL relative : aucune dépendance HTTP/HTTPS ni APP_URL ───────────────
    // Construit à partir du chemin courant → fonctionne en local, staging, prod
    var statusUrl = window.location.pathname.replace(/\/+$/, '') + '/status';

    var fill    = document.getElementById('bar-fill');
    var badge   = document.getElementById('pct-badge');
    var line    = document.getElementById('status-line');
    var overlay = document.getElementById('unlock-overlay');
    var PCT_TPL = {!! json_encode(__('dashboard.transfers.pct_completed')) !!};

    var serverPct  = {{ (int) $transfer->progress }};
    var displayPct = {{ (int) $transfer->progress }};
    var pollTimer  = null;
    var counterTimer = null;
    var failCount  = 0;
    var MAX_FAILS  = 5;
    var modalOpen  = {{ $transfer->status === 'paused' ? 'true' : 'false' }};

    // ── Compteur animé ────────────────────────────────────────────────────────
    function animateCounter(from, to, durationMs) {
        clearInterval(counterTimer);
        if (from === to) return;
        var steps    = Math.max(1, Math.ceil(durationMs / 80));
        var stepSize = (to - from) / steps;
        var current  = from;
        counterTimer = setInterval(function () {
            current += stepSize;
            var clamped = Math.round(Math.min(to, Math.max(from, current)));
            if (badge) {
                badge.textContent = clamped + '%';
                badge.style.left  = Math.min(96, Math.max(4, clamped)) + '%';
            }
            if (line) line.textContent = PCT_TPL.replace(':n', clamped);
            if (Math.abs(current - to) <= Math.abs(stepSize)) {
                clearInterval(counterTimer);
                if (badge) { badge.textContent = to + '%'; badge.style.left = Math.min(96, Math.max(4, to)) + '%'; }
                if (line)  line.textContent = PCT_TPL.replace(':n', to);
            }
        }, 80);
    }

    // ── Appliquer une nouvelle progression ───────────────────────────────────
    function applyProgress(pct) {
        if (fill) { fill.style.transition = 'width 5s linear'; fill.style.width = pct + '%'; }
        animateCounter(displayPct, pct, 4800);
        displayPct = pct;
    }

    // ── Polling ───────────────────────────────────────────────────────────────
    function poll() {
        fetch(statusUrl, {
            credentials: 'same-origin',                       // envoie le cookie de session
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':           'application/json'        // évite les redirections HTML
            }
        })
        .then(function (r) {
            // Toute réponse non-2xx (ex. 401 redirect → page login) est une erreur
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        })
        .then(function (d) {
            failCount = 0; // réinitialiser le compteur d'erreurs

            // Mise à jour barre si progression
            if (d.progress > serverPct) {
                serverPct = d.progress;
                applyProgress(serverPct);
            }

            // Virement terminé
            if (d.status === 'completed') {
                clearInterval(pollTimer);
                clearInterval(counterTimer);
                if (fill)  { fill.style.transition = 'width .4s ease'; fill.style.width = '100%'; fill.classList.add('tp-bar-fill--done'); }
                if (badge) { badge.textContent = '100%'; badge.style.left = '96%'; badge.classList.add('tp-pct-badge--done'); }
                if (line)  { line.textContent = PCT_TPL.replace(':n', 100); }
                setTimeout(function () { window.location.reload(); }, 800);
                return;
            }

            // Virement mis en pause → ouvrir modal
            if (d.status === 'paused' && !modalOpen) {
                modalOpen = true;
                clearInterval(pollTimer);
                if (fill) { fill.style.transition = 'none'; }
                var lvlText = document.getElementById('unlock-level-text');
                if (lvlText && d.current_text) {
                    lvlText.textContent  = d.current_text;
                    lvlText.style.display = '';
                }
                if (overlay) overlay.classList.add('is-open');
                var codeInp = document.getElementById('unlock-code-input');
                if (codeInp) codeInp.focus();
                return;
            }
        })
        .catch(function () {
            failCount++;
            // Après MAX_FAILS échecs consécutifs, informer l'utilisateur sans bloquer
            if (failCount === MAX_FAILS && line) {
                line.style.color = '#dc2626';
                line.textContent = {!! json_encode(__('dashboard.transfers.connection_error')) !!};
            }
            // On continue à essayer : la connexion peut revenir
        });
    }

    // ── Démarrage du polling (état processing uniquement) ────────────────────
    @if($transfer->status === 'processing')
    poll();                                         // premier appel immédiat
    pollTimer = setInterval(poll, 5000);            // puis toutes les 5 s
    document.addEventListener('visibilitychange', function () {
        if (!document.hidden) {
            failCount = 0;  // réinitialiser erreurs quand l'onglet revient au premier plan
            poll();
        }
    });
    @endif

    // ── Code de déblocage : formatage en majuscules à la frappe ─────────────
    var codeInput = document.getElementById('unlock-code-input');
    if (codeInput) {
        codeInput.addEventListener('input', function () {
            var v = this.value.toUpperCase().replace(/[^A-Z0-9-]/g, '');
            this.value = v;
            this.classList.remove('is-error');
            document.getElementById('unlock-code-error').textContent = '';
        });
    }

    // ── Désactiver le bouton au submit ────────────────────────────────────────
    var unlockForm = document.getElementById('unlock-form');
    if (unlockForm) {
        unlockForm.addEventListener('submit', function () {
            var btn = document.getElementById('unlock-submit-btn');
            if (btn) { btn.disabled = true; btn.textContent = {!! json_encode(__('dashboard.transfers.unlock_verifying')) !!}; }
        });
    }
})();
</script>
@endif
@endsection
