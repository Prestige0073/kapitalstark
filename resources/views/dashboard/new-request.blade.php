@extends('layouts.dashboard')
@section('title', 'Nouvelle Demande de Prêt')

@section('content')

<div class="dash-page-header">
    <div>
        <a href="{{ route('dashboard.requests') }}" style="font-size:13px;color:var(--text-muted);display:inline-flex;align-items:center;gap:6px;margin-bottom:8px;text-decoration:none;transition:color 0.2s;" onmouseenter="this.style.color='var(--blue)'" onmouseleave="this.style.color='var(--text-muted)'">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            {{ __('dashboard.new_request.back_link') }}
        </a>
        <h2>{{ __('dashboard.new_request.title') }}</h2>
        <p>{{ __('dashboard.new_request.sub') }}</p>
    </div>
</div>

{{-- Stepper --}}
<div class="nr-stepper" id="nr-stepper">
    @foreach([__('dashboard.new_request.step1_nav'),__('dashboard.new_request.step2_nav'),__('dashboard.new_request.step3_nav')] as $i => $s)
    <div class="nr-step {{ $i === 0 ? 'nr-step--active' : '' }}" id="nr-step-dot-{{ $i }}">
        <div class="nr-step__circle">
            <span class="nr-step__num">{{ $i + 1 }}</span>
            <svg class="nr-step__check" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="display:none;"><path d="M20 6L9 17l-5-5"/></svg>
        </div>
        <span class="nr-step__label">{{ $s }}</span>
    </div>
    @if($i < 2)
    <div class="nr-step__line" id="nr-line-{{ $i }}"></div>
    @endif
    @endforeach
</div>

<form action="{{ route('dashboard.requests.store') }}" method="POST" id="nr-form" novalidate>
    @csrf

    {{-- ──────────────── ÉTAPE 1 — PROJET ──────────────────── --}}
    <div class="dash-widget nr-panel" id="nr-panel-0">
        <div class="dash-widget__header">
            <span class="dash-widget__title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2" style="vertical-align:-3px;margin-right:6px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                {{ __('dashboard.new_request.step1_title') }}
            </span>
        </div>
        <div class="dash-widget__body" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

            <div class="nr-field" style="grid-column:1/-1;">
                <label class="nr-label" for="loan_type">{{ __('dashboard.new_request.loan_type') }} <span class="nr-req">*</span></label>
                <div class="nr-loan-types" id="nr-loan-types">
                    @php
                    $types = [
                        ['val'=>'immobilier', 'icon'=>'🏠','label'=>__('dashboard.new_request.type_immo')],
                        ['val'=>'automobile', 'icon'=>'🚗','label'=>__('dashboard.new_request.type_auto')],
                        ['val'=>'personnel',  'icon'=>'💳','label'=>__('dashboard.new_request.type_perso')],
                        ['val'=>'entreprise', 'icon'=>'💼','label'=>__('dashboard.new_request.type_pro')],
                        ['val'=>'agricole',   'icon'=>'🌾','label'=>__('dashboard.new_request.type_agri')],
                        ['val'=>'microcredit','icon'=>'🌱','label'=>__('dashboard.new_request.type_micro')],
                    ];
                    @endphp
                    @foreach($types as $t)
                    <label class="nr-type-card">
                        <input type="radio" name="loan_type" value="{{ $t['val'] }}" class="nr-type-input" {{ old('loan_type') === $t['val'] ? 'checked' : '' }}>
                        <span class="nr-type-inner">
                            <span class="nr-type-icon">{{ $t['icon'] }}</span>
                            <span class="nr-type-label">{{ $t['label'] }}</span>
                        </span>
                    </label>
                    @endforeach
                </div>
                @error('loan_type')<span class="nr-error">{{ $message }}</span>@enderror
            </div>

            <div class="nr-field">
                <label class="nr-label" for="amount">{{ __('dashboard.new_request.amount_label') }} <span class="nr-req">*</span></label>
                <div class="nr-amount-wrap">
                    <input type="number" name="amount" id="amount" class="nr-input nr-input--mono"
                           min="1000" max="10000000" step="500"
                           value="{{ old('amount', 50000) }}"
                           oninput="document.getElementById('amount-display').textContent=Number(this.value).toLocaleString('fr-FR')+'&nbsp;€'">
                    <span class="nr-input-suffix">€</span>
                </div>
                <div class="nr-range-row">
                    <input type="range" id="amount-range" min="1000" max="1000000" step="500" value="{{ old('amount', 50000) }}"
                           oninput="document.getElementById('amount').value=this.value;document.getElementById('amount-display').textContent=Number(this.value).toLocaleString('fr-FR')+'&nbsp;€'">
                    <span class="nr-range-value font-mono" id="amount-display">{{ number_format(old('amount', 50000), 0, ',', ' ') }}&nbsp;€</span>
                </div>
                @error('amount')<span class="nr-error">{{ $message }}</span>@enderror
            </div>

            <div class="nr-field">
                <label class="nr-label" for="duration">{{ __('dashboard.new_request.duration_label') }} <span class="nr-req">*</span></label>
                <div class="nr-select-wrap">
                    <select name="duration" id="duration" class="nr-select">
                        @php
                        $durations = [6=>'6 mois',12=>'1 an',24=>'2 ans',36=>'3 ans',48=>'4 ans',60=>'5 ans',84=>'7 ans',120=>'10 ans',180=>'15 ans',240=>'20 ans',300=>'25 ans',360=>'30 ans'];
                        @endphp
                        @foreach($durations as $months => $label)
                        <option value="{{ $months }}" {{ old('duration', 240) == $months ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <svg class="nr-select-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                @error('duration')<span class="nr-error">{{ $message }}</span>@enderror
            </div>

            <div class="nr-field" style="grid-column:1/-1;">
                <label class="nr-label" for="purpose">{{ __('dashboard.new_request.purpose_label') }} <span class="nr-req">*</span></label>
                <textarea name="purpose" id="purpose" class="nr-textarea" rows="3"
                          placeholder="{{ __('dashboard.new_request.purpose_ph') }}"
                          maxlength="500">{{ old('purpose') }}</textarea>
                <span class="nr-hint">{{ __('dashboard.new_request.purpose_hint') }}</span>
                @error('purpose')<span class="nr-error">{{ $message }}</span>@enderror
            </div>

            <div class="nr-field" style="grid-column:1/-1;">
                <label class="nr-label">{{ __('dashboard.new_request.apport_label') }}</label>
                <div class="nr-apport-row">
                    @php $apportOpts = ['Aucun apport'=>__('dashboard.new_request.apport_none'),'Moins de 10 %'=>__('dashboard.new_request.apport_lt10'),'10 % à 20 %'=>__('dashboard.new_request.apport_10_20'),'Plus de 20 %'=>__('dashboard.new_request.apport_gt20')]; @endphp
                    @foreach($apportOpts as $val => $lbl)
                    <label class="nr-radio-pill">
                        <input type="radio" name="apport" value="{{ $val }}" {{ old('apport', 'Moins de 10 %') === $val ? 'checked' : '' }}>
                        <span>{{ $lbl }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

        </div>
        <div class="nr-nav">
            <span></span>
            <button type="button" class="btn btn-primary" onclick="nrGo(1)">
                {{ __('dashboard.next_step') }}
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
    </div>

    {{-- ──────────────── ÉTAPE 2 — FINANCES ────────────────── --}}
    <div class="dash-widget nr-panel" id="nr-panel-1" style="display:none;">
        <div class="dash-widget__header">
            <span class="dash-widget__title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2" style="vertical-align:-3px;margin-right:6px;"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                {{ __('dashboard.new_request.step2_title') }}
            </span>
        </div>
        <div class="dash-widget__body" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

            <div class="nr-field">
                <label class="nr-label" for="income">{{ __('dashboard.new_request.income_label') }} <span class="nr-req">*</span></label>
                <div class="nr-amount-wrap">
                    <input type="number" name="income" id="income" class="nr-input nr-input--mono"
                           min="0" max="999999" step="100"
                           value="{{ old('income') }}"
                           placeholder="0"
                           oninput="nrUpdateRatio()">
                    <span class="nr-input-suffix">€ / mois</span>
                </div>
                @error('income')<span class="nr-error">{{ $message }}</span>@enderror
            </div>

            <div class="nr-field">
                <label class="nr-label" for="charges">{{ __('dashboard.new_request.charges_label') }} <span class="nr-req">*</span></label>
                <div class="nr-amount-wrap">
                    <input type="number" name="charges" id="charges" class="nr-input nr-input--mono"
                           min="0" max="999999" step="100"
                           value="{{ old('charges', 0) }}"
                           placeholder="0"
                           oninput="nrUpdateRatio()">
                    <span class="nr-input-suffix">€ / mois</span>
                </div>
                <span class="nr-hint">{{ __('dashboard.new_request.charges_hint') }}</span>
                @error('charges')<span class="nr-error">{{ $message }}</span>@enderror
            </div>

            <div class="nr-field">
                <label class="nr-label" for="employment">{{ __('dashboard.new_request.employment_label') }} <span class="nr-req">*</span></label>
                <div class="nr-select-wrap">
                    <select name="employment" id="employment" class="nr-select">
                        @php $empOpts = ['CDI'=>__('dashboard.new_request.emp_cdi'),'CDD'=>__('dashboard.new_request.emp_cdd'),'Fonctionnaire'=>__('dashboard.new_request.emp_fonc'),'Indépendant / Freelance'=>__('dashboard.new_request.emp_indep'),"Chef d'entreprise"=>__('dashboard.new_request.emp_boss'),'Retraité'=>__('dashboard.new_request.emp_retired'),"En recherche d'emploi"=>__('dashboard.new_request.emp_seeking'),'Étudiant'=>__('dashboard.new_request.emp_student'),'Autre'=>__('dashboard.new_request.emp_other')]; @endphp
                        @foreach($empOpts as $val => $lbl)
                        <option value="{{ $val }}" {{ old('employment') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                    <svg class="nr-select-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                @error('employment')<span class="nr-error">{{ $message }}</span>@enderror
            </div>

            <div class="nr-field">
                <label class="nr-label" for="seniority">{{ __('dashboard.new_request.seniority_label') }}</label>
                <div class="nr-select-wrap">
                    <select name="seniority" id="seniority" class="nr-select">
                        @php $senOpts = ['Moins de 6 mois'=>__('dashboard.new_request.sen_lt6m'),'6 à 12 mois'=>__('dashboard.new_request.sen_6_12m'),'1 à 3 ans'=>__('dashboard.new_request.sen_1_3y'),'3 à 10 ans'=>__('dashboard.new_request.sen_3_10y'),'Plus de 10 ans'=>__('dashboard.new_request.sen_gt10y')]; @endphp
                        @foreach($senOpts as $val => $lbl)
                        <option value="{{ $val }}" {{ old('seniority') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                    <svg class="nr-select-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </div>

            {{-- Ratio d'endettement dynamique --}}
            <div style="grid-column:1/-1;">
                <div class="nr-ratio-box" id="nr-ratio-box">
                    <div class="nr-ratio-box__head">
                        <span>{{ __('dashboard.new_request.ratio_head') }}</span>
                        <span class="font-mono nr-ratio-val" id="nr-ratio-val">—</span>
                    </div>
                    <div class="nr-ratio-bar">
                        <div class="nr-ratio-fill" id="nr-ratio-fill" style="width:0%;background:var(--blue);"></div>
                        <div class="nr-ratio-limit" style="left:35%;"></div>
                    </div>
                    <p class="nr-ratio-hint" id="nr-ratio-hint">{{ __('dashboard.new_request.ratio_hint') }}</p>
                </div>
            </div>

        </div>
        <div class="nr-nav">
            <button type="button" class="btn btn-outline" onclick="nrGo(0)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                {{ __('dashboard.back') }}
            </button>
            <button type="button" class="btn btn-primary" onclick="nrGo(2)">
                Étape suivante
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
    </div>

    {{-- ──────────────── ÉTAPE 3 — RÉCAP + DOCUMENTS ──────── --}}
    <div class="dash-widget nr-panel" id="nr-panel-2" style="display:none;">
        <div class="dash-widget__header">
            <span class="dash-widget__title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2" style="vertical-align:-3px;margin-right:6px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                {{ __('dashboard.new_request.step3_title') }}
            </span>
        </div>
        <div class="dash-widget__body">

            {{-- Récap --}}
            <div class="nr-recap" id="nr-recap">
                <div class="nr-recap__grid">
                    <div class="nr-recap__item">
                        <span class="nr-recap__key">{{ __('dashboard.new_request.recap_type') }}</span>
                        <span class="nr-recap__val" id="recap-type">—</span>
                    </div>
                    <div class="nr-recap__item">
                        <span class="nr-recap__key">{{ __('dashboard.new_request.recap_amount') }}</span>
                        <span class="nr-recap__val font-mono" id="recap-amount">—</span>
                    </div>
                    <div class="nr-recap__item">
                        <span class="nr-recap__key">{{ __('dashboard.new_request.recap_duration') }}</span>
                        <span class="nr-recap__val font-mono" id="recap-duration">—</span>
                    </div>
                    <div class="nr-recap__item">
                        <span class="nr-recap__key">{{ __('dashboard.new_request.recap_monthly') }}</span>
                        <span class="nr-recap__val font-mono" id="recap-monthly" style="color:var(--blue);font-weight:700;">—</span>
                    </div>
                    <div class="nr-recap__item">
                        <span class="nr-recap__key">{{ __('dashboard.new_request.recap_income') }}</span>
                        <span class="nr-recap__val font-mono" id="recap-income">—</span>
                    </div>
                    <div class="nr-recap__item">
                        <span class="nr-recap__key">{{ __('dashboard.new_request.recap_ratio') }}</span>
                        <span class="nr-recap__val font-mono" id="recap-ratio">—</span>
                    </div>
                </div>
                <div class="nr-recap__purpose" id="recap-purpose-wrap" style="display:none;">
                    <span class="nr-recap__key">{{ __('dashboard.new_request.recap_purpose') }}</span>
                    <span class="nr-recap__val" id="recap-purpose"></span>
                </div>
            </div>

            {{-- Documents à préparer --}}
            <div style="margin-top:28px;">
                <h4 style="font-size:15px;margin-bottom:16px;">{{ __('dashboard.new_request.docs_title') }}</h4>
                <div class="nr-docs-grid">
                    @php
                    $docsList = [
                        ['icon'=>'🪪','label'=>__('dashboard.new_request.doc1_label'),'desc'=>__('dashboard.new_request.doc1_desc')],
                        ['icon'=>'📊','label'=>__('dashboard.new_request.doc2_label'),'desc'=>__('dashboard.new_request.doc2_desc')],
                        ['icon'=>'🏦','label'=>__('dashboard.new_request.doc3_label'),'desc'=>__('dashboard.new_request.doc3_desc')],
                        ['icon'=>'📋','label'=>__('dashboard.new_request.doc4_label'),'desc'=>__('dashboard.new_request.doc4_desc')],
                        ['icon'=>'💼','label'=>__('dashboard.new_request.doc5_label'),'desc'=>__('dashboard.new_request.doc5_desc')],
                        ['icon'=>'📄','label'=>__('dashboard.new_request.doc6_label'),'desc'=>__('dashboard.new_request.doc6_desc')],
                    ];
                    @endphp
                    @foreach($docsList as $doc)
                    <div class="nr-doc-card">
                        <span class="nr-doc-icon">{{ $doc['icon'] }}</span>
                        <div>
                            <strong class="nr-doc-label">{{ $doc['label'] }}</strong>
                            <p class="nr-doc-desc">{{ $doc['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p style="font-size:13px;color:var(--text-muted);margin-top:16px;line-height:1.6;">
                    {{ __('dashboard.new_request.docs_note') }}
                </p>
            </div>

            {{-- Consentement --}}
            <div style="margin-top:24px;padding:20px;background:rgba(38,123,241,0.04);border:1px solid rgba(38,123,241,0.12);border-radius:var(--radius-md);">
                <label style="display:flex;gap:12px;align-items:flex-start;cursor:pointer;">
                    <input type="checkbox" name="consent" id="nr-consent" required style="margin-top:3px;flex-shrink:0;accent-color:var(--blue);">
                    <span style="font-size:13px;color:var(--text-muted);line-height:1.65;">
                        {!! __('dashboard.new_request.consent', ['privacy_url' => route('privacy')]) !!}
                    </span>
                </label>
                @error('consent')<p style="margin-top:8px;font-size:12px;color:var(--danger);">{{ $message }}</p>@enderror
            </div>

        </div>
        <div class="nr-nav">
            <button type="button" class="btn btn-outline" onclick="nrGo(1)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                {{ __('dashboard.back') }}
            </button>
            <button type="submit" class="btn btn-primary" id="nr-submit" style="gap:10px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ __('dashboard.new_request.submit') }}
            </button>
        </div>
    </div>

</form>

@endsection

@section('scripts')
<style>
/* ── Stepper ── */
.nr-stepper {
    display: flex;
    align-items: center;
    gap: 0;
    margin-bottom: 32px;
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: 20px 32px;
    box-shadow: var(--shadow-sm);
}
.nr-step {
    display: flex;
    align-items: center;
    gap: 10px;
}
.nr-step__circle {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: 2px solid rgba(38,123,241,0.2);
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.25s;
    flex-shrink: 0;
}
.nr-step__num   { font-size: 13px; font-weight: 700; color: var(--text-muted); font-family: var(--font-mono); }
.nr-step__label { font-size: 13px; font-weight: 600; color: var(--text-muted); white-space: nowrap; }

.nr-step--active   .nr-step__circle { border-color: var(--blue); background: var(--blue); }
.nr-step--active   .nr-step__num    { color: #fff; }
.nr-step--active   .nr-step__label  { color: var(--text); }
.nr-step--done     .nr-step__circle { border-color: var(--blue); background: rgba(38,123,241,0.1); }
.nr-step--done     .nr-step__num    { display: none; }
.nr-step--done     .nr-step__check  { display: block !important; stroke: var(--blue); }
.nr-step--done     .nr-step__label  { color: var(--blue); }

.nr-step__line {
    flex: 1;
    height: 2px;
    background: rgba(38,123,241,0.12);
    margin: 0 12px;
    border-radius: 2px;
    transition: background 0.3s;
}
.nr-step__line--done { background: rgba(38,123,241,0.4); }

/* ── Panel ── */
.nr-panel { margin-bottom: 0; }
.nr-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 28px;
    border-top: 1px solid rgba(38,123,241,0.07);
    margin-top: 4px;
}

/* ── Fields ── */
.nr-field { display: flex; flex-direction: column; gap: 6px; }
.nr-label { font-size: 13px; font-weight: 600; color: var(--text); }
.nr-req   { color: var(--blue); }
.nr-hint  { font-size: 11px; color: var(--text-muted); }
.nr-error { font-size: 12px; color: #ef4444; }

.nr-input {
    border: 1.5px solid rgba(38,123,241,0.18);
    border-radius: var(--radius-sm);
    padding: 11px 14px;
    font-size: 14px;
    font-family: var(--font-sans);
    color: var(--text);
    background: var(--white);
    outline: none;
    transition: border-color 0.2s;
    width: 100%;
}
.nr-input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(38,123,241,0.08); }
.nr-input--mono { font-family: var(--font-mono); }

.nr-amount-wrap { position: relative; }
.nr-input-suffix {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 12px;
    font-weight: 600;
    color: var(--text-muted);
    pointer-events: none;
}

.nr-select-wrap { position: relative; }
.nr-select {
    width: 100%;
    appearance: none;
    -webkit-appearance: none;
    border: 1.5px solid rgba(38,123,241,0.18);
    border-radius: var(--radius-sm);
    padding: 11px 36px 11px 14px;
    font-size: 14px;
    font-family: var(--font-sans);
    color: var(--text);
    background: var(--white);
    outline: none;
    cursor: pointer;
    transition: border-color 0.2s;
}
.nr-select:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(38,123,241,0.08); }
.nr-select-arrow { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; color: var(--text-muted); }

.nr-textarea {
    border: 1.5px solid rgba(38,123,241,0.18);
    border-radius: var(--radius-sm);
    padding: 11px 14px;
    font-size: 14px;
    font-family: var(--font-sans);
    color: var(--text);
    background: var(--white);
    outline: none;
    resize: vertical;
    transition: border-color 0.2s;
    min-height: 80px;
}
.nr-textarea:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(38,123,241,0.08); }

/* ── Loan type cards ── */
.nr-loan-types {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 10px;
}
.nr-type-card { cursor: pointer; }
.nr-type-input { display: none; }
.nr-type-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 14px 8px;
    border: 2px solid rgba(38,123,241,0.12);
    border-radius: var(--radius-md);
    background: var(--white);
    transition: all 0.2s;
    font-family: var(--font-sans);
}
.nr-type-inner:hover { border-color: rgba(38,123,241,0.35); background: rgba(38,123,241,0.03); }
.nr-type-input:checked + .nr-type-inner { border-color: var(--blue); background: rgba(38,123,241,0.07); }
.nr-type-icon  { font-size: 22px; }
.nr-type-label { font-size: 11px; font-weight: 700; color: var(--text); text-transform: uppercase; letter-spacing: 0.04em; text-align: center; }

/* ── Apport pills ── */
.nr-apport-row { display: flex; gap: 8px; flex-wrap: wrap; }
.nr-radio-pill { cursor: pointer; }
.nr-radio-pill input { display: none; }
.nr-radio-pill span {
    display: inline-block;
    padding: 8px 16px;
    border: 1.5px solid rgba(38,123,241,0.18);
    border-radius: 100px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-muted);
    transition: all 0.2s;
    background: var(--white);
}
.nr-radio-pill input:checked + span { border-color: var(--blue); background: var(--blue); color: #fff; }
.nr-radio-pill span:hover { border-color: var(--blue); color: var(--blue); }

/* ── Range slider ── */
.nr-range-row { display: flex; align-items: center; gap: 12px; margin-top: 8px; }
.nr-range-row input[type=range] { flex: 1; accent-color: var(--blue); }
.nr-range-value { font-size: 14px; font-weight: 700; color: var(--blue); white-space: nowrap; min-width: 80px; text-align: right; }

/* ── Debt ratio box ── */
.nr-ratio-box {
    background: rgba(38,123,241,0.04);
    border: 1px solid rgba(38,123,241,0.12);
    border-radius: var(--radius-md);
    padding: 18px 22px;
}
.nr-ratio-box__head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 13px; font-weight: 600; color: var(--text); }
.nr-ratio-val { font-size: 20px; font-weight: 700; }
.nr-ratio-bar {
    height: 8px;
    background: rgba(38,123,241,0.1);
    border-radius: 4px;
    position: relative;
    overflow: visible;
    margin-bottom: 10px;
}
.nr-ratio-fill { height: 100%; border-radius: 4px; transition: width 0.4s var(--ease), background 0.3s; }
.nr-ratio-limit {
    position: absolute;
    top: -4px;
    width: 2px;
    height: 16px;
    background: #ef4444;
    border-radius: 2px;
}
.nr-ratio-limit::after {
    content: '35%';
    position: absolute;
    top: -18px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 10px;
    color: #ef4444;
    font-weight: 700;
    white-space: nowrap;
    font-family: var(--font-mono);
}
.nr-ratio-hint { font-size: 12px; color: var(--text-muted); margin: 0; }

/* ── Recap ── */
.nr-recap {
    background: rgba(38,123,241,0.03);
    border: 1px solid rgba(38,123,241,0.1);
    border-radius: var(--radius-md);
    padding: 20px 24px;
}
.nr-recap__grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0; }
.nr-recap__item { padding: 12px 16px; border-bottom: 1px solid rgba(38,123,241,0.07); }
.nr-recap__item:nth-child(2n+1) { border-right: 1px solid rgba(38,123,241,0.07); }
.nr-recap__key { font-size: 11px; text-transform: uppercase; letter-spacing: 0.06em; font-weight: 700; color: var(--text-muted); display: block; margin-bottom: 4px; }
.nr-recap__val { font-size: 15px; color: var(--text); font-weight: 600; }
.nr-recap__purpose { padding: 12px 16px; border-top: 1px solid rgba(38,123,241,0.07); display: flex; gap: 16px; align-items: flex-start; }

/* ── Documents ── */
.nr-docs-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.nr-doc-card {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    padding: 14px 16px;
    border: 1px solid rgba(38,123,241,0.1);
    border-radius: var(--radius-md);
    background: var(--white);
}
.nr-doc-icon { font-size: 20px; flex-shrink: 0; margin-top: 1px; }
.nr-doc-label { font-size: 13px; font-weight: 700; color: var(--text); display: block; margin-bottom: 2px; }
.nr-doc-desc  { font-size: 12px; color: var(--text-muted); line-height: 1.5; margin: 0; }

@media (max-width: 768px) {
    .nr-loan-types { grid-template-columns: repeat(3, 1fr); }
    .dash-widget__body[style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; display: grid !important; }
    .nr-recap__grid { grid-template-columns: 1fr; }
    .nr-docs-grid   { grid-template-columns: 1fr; }
    .nr-stepper     { padding: 16px; gap: 4px; }
    .nr-step__label { display: none; }
}
@media (max-width: 480px) {
    .nr-loan-types { grid-template-columns: 1fr 1fr; gap: 8px; }
    .nr-type-card  { padding: 10px 6px; }
    .nr-type-icon  { font-size: 20px; }
    .nr-type-label { font-size: 11px; }
    .nr-stepper    { padding: 12px; gap: 2px; }
    .nr-step__num  { width: 22px; height: 22px; font-size: 10px; }
    .nr-nav        { flex-direction: column; gap: 8px; }
    .nr-nav .btn   { width: 100%; justify-content: center; }
    .nr-field input, .nr-field select, .nr-field textarea { font-size: 16px; }
}
</style>

<script>
(function () {
    'use strict';

    var current = 0;
    var total   = 3;

    function nrUpdateDots(to) {
        for (var i = 0; i < total; i++) {
            var dot  = document.getElementById('nr-step-dot-' + i);
            var line = document.getElementById('nr-line-' + i);
            dot.classList.remove('nr-step--active', 'nr-step--done');
            if (i < to)      dot.classList.add('nr-step--done');
            else if (i === to) dot.classList.add('nr-step--active');
            if (line) line.classList.toggle('nr-step__line--done', i < to);
        }
    }

    window.nrGo = function (to) {
        if (to === 2) nrBuildRecap();
        document.getElementById('nr-panel-' + current).style.display = 'none';
        document.getElementById('nr-panel-' + to).style.display = '';
        current = to;
        nrUpdateDots(to);
        window.scrollTo({ top: document.getElementById('nr-stepper').offsetTop - 24, behavior: 'smooth' });
    };

    // Debt ratio live calc
    window.nrUpdateRatio = function () {
        var income  = parseFloat(document.getElementById('income').value)  || 0;
        var charges = parseFloat(document.getElementById('charges').value) || 0;
        var box     = document.getElementById('nr-ratio-box');
        var fill    = document.getElementById('nr-ratio-fill');
        var val     = document.getElementById('nr-ratio-val');
        var hint    = document.getElementById('nr-ratio-hint');

        if (!income) {
            val.textContent = '—';
            fill.style.width = '0%';
            hint.textContent = '{{ __('dashboard.new_request.ratio_hint') }}';
            fill.style.background = 'var(--blue)';
            return;
        }

        var ratio  = Math.round((charges / income) * 100);
        var pct    = Math.min(ratio, 100);
        val.textContent = ratio + '%';
        fill.style.width = pct + '%';

        if (ratio < 28) {
            fill.style.background = '#22c55e';
            hint.textContent = 'Excellent ! Votre taux actuel est très favorable pour un emprunt.';
        } else if (ratio < 35) {
            fill.style.background = 'var(--blue)';
            hint.textContent = 'Votre taux d\'endettement est dans la norme. Un financement est possible.';
        } else if (ratio < 45) {
            fill.style.background = '#f59e0b';
            hint.textContent = 'Attention — votre taux dépasse 35%. Un conseiller étudiera votre dossier au cas par cas.';
        } else {
            fill.style.background = '#ef4444';
            hint.textContent = 'Taux élevé. Nous vous recommandons de contacter un conseiller avant de soumettre.';
        }
    };

    // Recap builder
    function nrBuildRecap() {
        var typeInput = document.querySelector('input[name=loan_type]:checked');
        var typeLabels = { immobilier:'Prêt Immobilier 🏠', automobile:'Prêt Automobile 🚗', personnel:'Prêt Personnel 💳', entreprise:'Prêt Entreprise 💼', agricole:'Prêt Agricole 🌾', microcredit:'Microcrédit 🌱' };

        document.getElementById('recap-type').textContent     = typeInput ? (typeLabels[typeInput.value] || typeInput.value) : '—';

        var amount   = parseFloat(document.getElementById('amount').value) || 0;
        var duration = parseInt(document.getElementById('duration').value) || 0;
        var income   = parseFloat(document.getElementById('income').value)  || 0;
        var charges  = parseFloat(document.getElementById('charges').value) || 0;

        document.getElementById('recap-amount').textContent   = amount   ? amount.toLocaleString('fr-FR') + ' €'  : '—';
        document.getElementById('recap-duration').textContent = duration ? (duration < 24 ? duration + ' mois' : Math.round(duration / 12) + ' ans') : '—';

        // Estimate monthly payment at 2.5% (indicative)
        if (amount && duration) {
            var r = 0.025 / 12;
            var monthly = amount * r * Math.pow(1 + r, duration) / (Math.pow(1 + r, duration) - 1);
            document.getElementById('recap-monthly').textContent = Math.round(monthly).toLocaleString('fr-FR') + ' € / mois (estimé)';
        }

        if (income) {
            document.getElementById('recap-income').textContent = income.toLocaleString('fr-FR') + ' € / mois';
            var ratio = Math.round((charges / income) * 100);
            document.getElementById('recap-ratio').textContent  = ratio + '%';
        }

        var purpose = document.getElementById('purpose').value.trim();
        if (purpose) {
            document.getElementById('recap-purpose-wrap').style.display = '';
            document.getElementById('recap-purpose').textContent = purpose;
        } else {
            document.getElementById('recap-purpose-wrap').style.display = 'none';
        }
    }
})();
</script>
@endsection
