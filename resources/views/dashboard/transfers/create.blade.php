@extends('layouts.dashboard')
@section('title', __('dashboard.transfers.new_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/transfer.css') }}">
@endsection

@section('content')

<div class="transfer-create-wrap">
    <div class="dash-card transfer-form-card">

        {{-- En-tête ──────────────────────────────────────────── --}}
        <div class="transfer-form-header">
            <div class="transfer-form-header__icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="22" y1="2" x2="11" y2="13"/>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
            </div>
            <div>
                <h2 class="transfer-form-header__title">{{ __('dashboard.transfers.new_title') }}</h2>
                <p class="transfer-form-header__sub">{{ __('dashboard.transfers.new_sub') }}</p>
            </div>
        </div>

        {{-- Erreurs ───────────────────────────────────────────── --}}
        @if($errors->any())
        <div class="transfer-alert transfer-alert--error">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <ul>
                @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('dashboard.transfers.store') }}" method="POST" id="transfer-form" novalidate>
            @csrf

            {{-- ── Bénéficiaire ──────────────────────────────── --}}
            <div class="transfer-section-label">{{ __('dashboard.transfers.section_recipient') }}</div>

            <div class="transfer-field-row">
                <div class="transfer-field">
                    <label for="recipient_name" class="transfer-label">
                        {{ __('dashboard.transfers.name_label') }} <span class="transfer-required">*</span>
                    </label>
                    <input type="text" id="recipient_name" name="recipient_name"
                           value="{{ old('recipient_name') }}"
                           placeholder="Jean Martin"
                           class="transfer-input @error('recipient_name') is-error @enderror"
                           autocomplete="off" required>
                    <div class="transfer-error-msg" id="err-recipient_name">
                        @error('recipient_name'){{ $message }}@enderror
                    </div>
                </div>
            </div>

            <div class="transfer-field-row transfer-field-row--2">
                <div class="transfer-field">
                    <label for="recipient_iban" class="transfer-label">
                        {{ __('dashboard.transfers.iban_label') }} <span class="transfer-required">*</span>
                    </label>
                    <input type="text" id="recipient_iban" name="recipient_iban"
                           value="{{ old('recipient_iban') }}"
                           placeholder="FR76 3000 4028 3798 7654 3210 943"
                           class="transfer-input transfer-input--mono @error('recipient_iban') is-error @enderror"
                           autocomplete="off" maxlength="34" required>
                    <div class="transfer-error-msg" id="err-recipient_iban">
                        @error('recipient_iban'){{ $message }}@enderror
                    </div>
                    <div class="transfer-hint">{{ __('dashboard.transfers.iban_hint') }}</div>
                </div>
                <div class="transfer-field">
                    <label for="recipient_bic" class="transfer-label">
                        {{ __('dashboard.transfers.bic_label') }} <span class="transfer-optional">({{ __('dashboard.transfers.optional') }})</span>
                    </label>
                    <input type="text" id="recipient_bic" name="recipient_bic"
                           value="{{ old('recipient_bic') }}"
                           placeholder="BNPAFRPPXXX"
                           class="transfer-input transfer-input--mono @error('recipient_bic') is-error @enderror"
                           autocomplete="off" maxlength="11">
                    <div class="transfer-error-msg" id="err-recipient_bic">
                        @error('recipient_bic'){{ $message }}@enderror
                    </div>
                </div>
            </div>

            {{-- ── Transaction ───────────────────────────────── --}}
            <div class="transfer-section-label" style="margin-top:28px;">{{ __('dashboard.transfers.section_details') }}</div>

            <div class="transfer-field-row">
                <div class="transfer-field transfer-field--amount">
                    <label for="amount" class="transfer-label">
                        {{ __('dashboard.transfers.amount_label') }} <span class="transfer-required">*</span>
                    </label>
                    <div class="transfer-amount-wrap">
                        <input type="number" id="amount" name="amount"
                               value="{{ old('amount') }}"
                               placeholder="0,00"
                               min="1" max="{{ min(100000, $balance) }}" step="0.01"
                               class="transfer-input transfer-input--amount @error('amount') is-error @enderror"
                               required>
                        <span class="transfer-amount-currency">€</span>
                    </div>
                    <div class="transfer-error-msg" id="err-amount">
                        @error('amount'){{ $message }}@enderror
                    </div>
                    <div class="transfer-balance-hint">
                        <span class="transfer-balance-hint__label">{{ __('dashboard.transfers.balance_label') }}</span>
                        <span class="transfer-balance-hint__value" id="balance-display">
                            {{ number_format($balance, 2, ',', ' ') }} €
                        </span>
                        <button type="button" class="transfer-balance-hint__max" id="btn-max" title="{{ __('dashboard.transfers.max_btn') }}">
                            {{ __('dashboard.transfers.max_btn') }}
                        </button>
                    </div>
                    <div class="transfer-hint" id="amount-range-hint">
                        Entre 1 € et {{ $balance > 0 ? number_format(min(100000, $balance), 2, ',', ' ') . ' €' : '100 000 €' }}
                    </div>
                </div>
            </div>

            <div class="transfer-field-row">
                <div class="transfer-field">
                    <label for="label" class="transfer-label">
                        {{ __('dashboard.transfers.label_label') }} <span class="transfer-optional">({{ __('dashboard.transfers.optional') }})</span>
                    </label>
                    <input type="text" id="label" name="label"
                           value="{{ old('label') }}"
                           placeholder="Remboursement loyer juillet…"
                           maxlength="140"
                           class="transfer-input @error('label') is-error @enderror">
                    <div class="transfer-char-count"><span id="label-count">0</span> / 140</div>
                </div>
            </div>

            <div class="transfer-field-row">
                <div class="transfer-field">
                    <label for="note" class="transfer-label">
                        {{ __('dashboard.transfers.note_label') }} <span class="transfer-optional">({{ __('dashboard.transfers.not_transmitted') }})</span>
                    </label>
                    <textarea id="note" name="note" rows="3"
                              placeholder="Informations supplémentaires pour votre dossier…"
                              maxlength="500"
                              class="transfer-input transfer-textarea @error('note') is-error @enderror">{{ old('note') }}</textarea>
                </div>
            </div>

            {{-- ── Récapitulatif dynamique ────────────────────── --}}
            <div class="transfer-recap" id="transfer-recap" style="display:none;">
                <div class="transfer-recap__title">{{ __('dashboard.transfers.recap_title') }}</div>
                <div class="transfer-recap__row">
                    <span>{{ __('dashboard.transfers.recap_recipient') }}</span>
                    <strong id="recap-name">—</strong>
                </div>
                <div class="transfer-recap__row">
                    <span>{{ __('dashboard.transfers.recap_iban') }}</span>
                    <strong id="recap-iban" class="mono">—</strong>
                </div>
                <div class="transfer-recap__row transfer-recap__row--amount">
                    <span>{{ __('dashboard.transfers.recap_amount') }}</span>
                    <strong id="recap-amount" class="amount">0,00 €</strong>
                </div>
                <div class="transfer-recap__row">
                    <span>{{ __('dashboard.transfers.recap_fees') }}</span>
                    <strong style="color:#15803d;">{{ __('dashboard.transfers.recap_fees_free') }}</strong>
                </div>
            </div>

            {{-- ── Bouton ─────────────────────────────────────── --}}
            <div class="transfer-actions">
                <a href="{{ route('dashboard.transfers.index') }}" class="transfer-btn transfer-btn--cancel">
                    {{ __('dashboard.transfers.cancel_btn') }}
                </a>
                <button type="submit" class="transfer-btn transfer-btn--submit" id="submit-btn" disabled>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    {{ __('dashboard.transfers.submit_btn') }}
                </button>
            </div>

        </form>
    </div>

    {{-- Panneau d'info ──────────────────────────────────────── --}}
    <div class="transfer-info-panel">
        <div class="transfer-info-block">
            <div class="transfer-info-block__icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
                <div class="transfer-info-block__title">{{ __('dashboard.transfers.info_secure_title') }}</div>
                <div class="transfer-info-block__text">{{ __('dashboard.transfers.info_secure_text') }}</div>
            </div>
        </div>
        <div class="transfer-info-block">
            <div class="transfer-info-block__icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <div class="transfer-info-block__title">{{ __('dashboard.transfers.info_delay_title') }}</div>
                <div class="transfer-info-block__text">{{ __('dashboard.transfers.info_delay_text') }}</div>
            </div>
        </div>
        <div class="transfer-info-block">
            <div class="transfer-info-block__icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div>
                <div class="transfer-info-block__title">{{ __('dashboard.transfers.info_fees_title') }}</div>
                <div class="transfer-info-block__text">{{ __('dashboard.transfers.info_fees_text') }}</div>
            </div>
        </div>
        <div class="transfer-info-block">
            <div class="transfer-info-block__icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <div>
                <div class="transfer-info-block__title">{{ __('dashboard.transfers.info_track_title') }}</div>
                <div class="transfer-info-block__text">{{ __('dashboard.transfers.info_track_text') }}</div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
(function () {
    var BALANCE    = {{ (float)$balance }};
    var MAX_AMOUNT = Math.min(100000, BALANCE);

    // Messages traduits injectés depuis PHP
    var MSG_NAME_MIN       = '{{ __('dashboard.transfers.js_name_min') }}';
    var MSG_IBAN_INVALID   = '{{ __('dashboard.transfers.js_iban_invalid') }}';
    var MSG_BIC_INVALID    = '{{ __('dashboard.transfers.js_bic_invalid') }}';
    var MSG_AMOUNT_MIN     = '{{ __('dashboard.transfers.js_amount_min') }}';
    var MSG_INSUFFICIENT   = '{{ __('dashboard.transfers.js_insufficient') }}';
    var MSG_AMOUNT_MAX     = '{{ __('dashboard.transfers.js_amount_max') }}';
    var MSG_NO_BALANCE     = '{{ __('dashboard.transfers.js_no_balance') }}';
    var MSG_INSUF_BAL_TPL  = '{{ __('dashboard.transfers.js_insufficient_bal') }}';

    var nameInput   = document.getElementById('recipient_name');
    var ibanInput   = document.getElementById('recipient_iban');
    var bicInput    = document.getElementById('recipient_bic');
    var amountInput = document.getElementById('amount');
    var labelInput  = document.getElementById('label');
    var recap       = document.getElementById('transfer-recap');
    var submitBtn   = document.getElementById('submit-btn');
    var labelCount  = document.getElementById('label-count');
    var btnMax      = document.getElementById('btn-max');
    var balanceBar  = document.getElementById('balance-display');

    // Coloriser le solde selon le montant saisi
    function updateBalanceBar(v) {
        if (!balanceBar) return;
        if (isNaN(v) || v <= 0) {
            balanceBar.style.color = '';
        } else if (v > BALANCE) {
            balanceBar.style.color = '#dc2626';
        } else if (v > BALANCE * 0.8) {
            balanceBar.style.color = '#d97706';
        } else {
            balanceBar.style.color = '#16a34a';
        }
    }

    // Bouton "Max"
    if (btnMax) {
        btnMax.addEventListener('click', function () {
            if (BALANCE <= 0) return;
            var maxVal = Math.min(BALANCE, 100000);
            amountInput.value = maxVal.toFixed(2);
            validateAmount(maxVal);
            updateRecap();
        });
    }

    ibanInput.addEventListener('input', function () {
        this.value = this.value.toUpperCase().replace(/\s/g, '');
        validateIban(this.value);
        updateRecap();
    });

    bicInput.addEventListener('input', function () {
        this.value = this.value.toUpperCase().replace(/\s/g, '');
        validateBic(this.value);
    });

    amountInput.addEventListener('input', function () {
        var v = parseFloat(this.value);
        validateAmount(v);
        updateBalanceBar(v);
        updateRecap();
    });

    nameInput.addEventListener('input', function () {
        setFieldState('recipient_name', this.value.trim().length >= 2, MSG_NAME_MIN);
        updateRecap();
    });

    labelInput.addEventListener('input', function () {
        labelCount.textContent = this.value.length;
    });

    function validateIban(v) {
        var ok = /^[A-Z]{2}\d{2}[A-Z0-9]{1,30}$/.test(v) && v.length >= 14;
        setFieldState('recipient_iban', ok, MSG_IBAN_INVALID);
        return ok;
    }

    function validateBic(v) {
        if (!v) { setFieldState('recipient_bic', null); return true; }
        var ok = /^[A-Z]{6}[A-Z0-9]{2}([A-Z0-9]{3})?$/.test(v);
        setFieldState('recipient_bic', ok, MSG_BIC_INVALID);
        return ok;
    }

    function validateAmount(v) {
        if (isNaN(v) || v < 1) {
            setFieldState('amount', false, MSG_AMOUNT_MIN);
            return false;
        }
        if (BALANCE <= 0) {
            setFieldState('amount', false, MSG_INSUFFICIENT);
            return false;
        }
        if (v > BALANCE) {
            setFieldState('amount', false,
                MSG_INSUF_BAL_TPL.replace(':balance',
                    BALANCE.toLocaleString('{{ app()->getLocale() }}', {minimumFractionDigits: 2})));
            return false;
        }
        if (v > 100000) {
            setFieldState('amount', false, MSG_AMOUNT_MAX);
            return false;
        }
        setFieldState('amount', true);
        return true;
    }

    function setFieldState(fieldId, ok, errorMsg) {
        var input = document.getElementById(fieldId) || document.querySelector('[name="' + fieldId + '"]');
        var errEl = document.getElementById('err-' + fieldId);
        if (!input) return;
        if (ok === null) {
            input.classList.remove('is-error', 'is-valid');
            if (errEl) errEl.textContent = '';
        } else if (ok) {
            input.classList.remove('is-error');
            input.classList.add('is-valid');
            if (errEl) errEl.textContent = '';
        } else {
            input.classList.add('is-error');
            input.classList.remove('is-valid');
            if (errEl) errEl.textContent = errorMsg || '';
        }
        checkCanSubmit();
    }

    function checkCanSubmit() {
        var nameOk   = nameInput.value.trim().length >= 2;
        var ibanOk   = /^[A-Z]{2}\d{2}[A-Z0-9]{1,30}$/.test(ibanInput.value) && ibanInput.value.length >= 14;
        var v        = parseFloat(amountInput.value);
        var amountOk = !isNaN(v) && v >= 1 && v <= Math.min(100000, BALANCE) && BALANCE > 0;
        submitBtn.disabled = !(nameOk && ibanOk && amountOk);
    }

    function updateRecap() {
        var name   = nameInput.value.trim();
        var iban   = ibanInput.value.trim();
        var amount = parseFloat(amountInput.value);

        if (name || iban || amount) {
            recap.style.display = 'block';
            document.getElementById('recap-name').textContent   = name || '—';
            document.getElementById('recap-iban').textContent   = iban || '—';
            document.getElementById('recap-amount').textContent =
                (!isNaN(amount) && amount > 0)
                    ? amount.toLocaleString('{{ app()->getLocale() }}', {minimumFractionDigits: 2}) + ' €'
                    : '0,00 €';
        } else {
            recap.style.display = 'none';
        }
    }

    // Init : si le solde est 0, avertir
    if (BALANCE <= 0) {
        var errEl = document.getElementById('err-amount');
        if (errEl) errEl.textContent = MSG_NO_BALANCE;
        if (amountInput) {
            amountInput.disabled = true;
            amountInput.classList.add('is-error');
        }
        if (submitBtn) submitBtn.disabled = true;
    }
})();
</script>
@endsection
