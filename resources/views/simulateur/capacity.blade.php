@extends('layouts.app')
@section('title', __('simulator.capacity.meta_title'))
@section('description', __('simulator.capacity.meta_desc'))
@section('styles')
<link rel="stylesheet" href="{{ asset('css/simulator.css') }}">
@endsection

@section('content')

{{-- Hero --}}
<section class="sim-hero">
    <div class="container sim-hero__inner">
        <div class="section-header" style="margin-bottom:0;">
            <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('simulator.free_tool') }}</span>
            <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('simulator.capacity.hero_title') }}</h1>
            <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;margin-top:12px;">
                {{ __('simulator.capacity.hero_desc') }}
            </p>
        </div>
        <nav class="sim-tools-nav reveal stagger-3" aria-label="{{ __('simulator.nav_sim') }}">
            <a href="{{ route('simulator.index') }}" class="sim-tool-link">{{ __('simulator.nav_sim') }}</a>
            <a href="{{ route('simulator.compare') }}" class="sim-tool-link">{{ __('simulator.nav_comp') }}</a>
            <a href="{{ route('simulator.capacity') }}" class="sim-tool-link active" aria-current="page">{{ __('simulator.nav_cap') }}</a>
        </nav>
    </div>
</section>

{{-- Calculateur --}}
<section class="sim-main">
    <div class="container">
        <div class="sim-layout">

            {{-- Gauche : Paramètres --}}
            <div class="sim-controls reveal stagger-1">
                <h3 style="margin-bottom:32px;font-size:18px;">{{ __('simulator.capacity.params') }}</h3>

                <div class="sim-group">
                    <div class="sim-label">
                        <span>{{ __('simulator.capacity.income') }}</span>
                        <span id="inc-val" class="font-mono" style="color:var(--blue);font-size:20px;">3 500 €</span>
                    </div>
                    <input type="range" class="sim-slider" id="income"
                        min="500" max="15000" step="100" value="3500"
                        aria-label="{{ __('simulator.capacity.income') }}">
                    <div class="sim-range-labels"><span>500 €</span><span>15 000 €</span></div>
                </div>

                <div class="sim-group">
                    <div class="sim-label">
                        <span>{{ __('simulator.capacity.charges') }}</span>
                        <span id="chg-val" class="font-mono" style="color:var(--blue);font-size:20px;">0 €</span>
                    </div>
                    <input type="range" class="sim-slider" id="charges"
                        min="0" max="5000" step="50" value="0"
                        aria-label="{{ __('simulator.capacity.charges') }}">
                    <div class="sim-range-labels"><span>0 €</span><span>5 000 €</span></div>
                </div>
                <p style="font-size:12px;color:var(--text-muted);margin-top:-24px;margin-bottom:28px;">
                    {{ __('simulator.capacity.charges_note') }}
                </p>

                <div class="sim-group">
                    <div class="sim-label"><span>{{ __('simulator.capacity.loan_type') }}</span></div>
                    <select class="compare-select" id="cap-type" aria-label="{{ __('simulator.capacity.loan_type') }}">
                        <option value="1.9">🏠 {{ __('simulator.type_immo') }} — 1.9%</option>
                        <option value="2.5">🚗 {{ __('simulator.type_auto') }} — 2.5%</option>
                        <option value="3.2">💳 {{ __('simulator.type_perso') }} — 3.2%</option>
                        <option value="2.8">🏢 {{ __('simulator.type_pro') }} — 2.8%</option>
                        <option value="2.3">🌾 {{ __('simulator.type_agri') }} — 2.3%</option>
                        <option value="4.5">🤲 {{ __('simulator.type_micro') }} — 4.5%</option>
                    </select>
                </div>

                <div class="sim-group">
                    <div class="sim-label">
                        <span>{{ __('simulator.capacity.duration') }}</span>
                        <span id="dur-val" class="font-mono" style="color:var(--blue);font-size:20px;">20 {{ __('ui.simulator.years') }}</span>
                    </div>
                    <input type="range" class="sim-slider" id="cap-duration"
                        min="1" max="30" step="1" value="20"
                        aria-label="{{ __('simulator.capacity.duration') }}">
                    <div class="sim-range-labels"><span>1 {{ __('ui.simulator.years') }}</span><span>30 {{ __('ui.simulator.years') }}</span></div>
                </div>

                <div class="cap-info-box">
                    {!! __('simulator.capacity.info_box') !!}
                </div>
            </div>

            {{-- Droite : Résultats --}}
            <div class="sim-results-panel reveal stagger-2">

                <div class="cap-gauge-wrap">
                    <p class="cap-gauge-label">{{ __('simulator.capacity.gauge_label') }}</p>
                    <div style="display:flex;flex-direction:column;align-items:center;">
                        <svg viewBox="0 0 200 112" class="cap-gauge-svg" role="img" aria-label="{{ __('simulator.capacity.gauge_label') }}">
                            <path d="M 10 100 A 90 90 0 0 1 100 10" fill="none" stroke="#10b981" stroke-width="18" stroke-linecap="butt" opacity="0.2"/>
                            <path d="M 100 10 A 90 90 0 0 1 172.4 55" fill="none" stroke="var(--blue)" stroke-width="18" stroke-linecap="butt" opacity="0.15"/>
                            <path d="M 172.4 55 A 90 90 0 0 1 190 100" fill="none" stroke="#f59e0b" stroke-width="18" stroke-linecap="butt" opacity="0.3"/>
                            <path d="M 178.7 67.8 A 90 90 0 0 1 190 100" fill="none" stroke="#ef4444" stroke-width="18" stroke-linecap="butt" opacity="0.0"/>
                            <path d="M 10 100 A 90 90 0 0 1 190 100" fill="none" stroke="rgba(38,123,241,0.08)" stroke-width="14" stroke-linecap="round"/>
                            <path id="cap-gauge-fill"
                                d="M 10 100 A 90 90 0 0 1 190 100"
                                fill="none" stroke="var(--blue)" stroke-width="14"
                                stroke-linecap="round"
                                stroke-dasharray="0 283"
                                style="transition:stroke-dasharray 0.5s ease, stroke 0.4s;"/>
                            <line x1="10" y1="100" x2="10" y2="100" id="gauge-needle"
                                stroke="var(--navy)" stroke-width="3" stroke-linecap="round"
                                style="transition: all 0.5s ease;"/>
                        </svg>
                        <div style="margin-top:-8px;text-align:center;">
                            <p class="font-mono" id="gauge-pct" style="font-size:36px;font-weight:700;color:var(--text);line-height:1;">0%</p>
                            <p class="cap-gauge-sub" id="gauge-status">{{ __('simulator.capacity.gauge_none') }}</p>
                        </div>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-top:16px;font-size:11px;color:var(--text-muted);padding-inline:8px;">
                        <span style="color:#10b981;font-weight:600;">0%</span>
                        <span style="color:var(--blue);font-weight:600;">35%</span>
                        <span style="color:#f59e0b;font-weight:600;">43%</span>
                        <span style="color:#ef4444;font-weight:600;">50%</span>
                        <span style="font-weight:600;">60%</span>
                    </div>
                </div>

                <div class="sim-main-result" id="cap-main-result">
                    <p class="sim-main-result__label">{{ __('simulator.capacity.cap_label') }}</p>
                    <p class="sim-main-result__value font-mono" id="cap-main-value">—</p>
                    <p class="sim-main-result__sub">{{ __('simulator.capacity.monthly_max') }} <span id="cap-main-monthly">—</span></p>
                </div>

                <div>
                    <p style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);margin-bottom:14px;">
                        {{ __('simulator.capacity.profiles_head') }}
                    </p>
                    <div class="cap-profiles">
                        <div class="cap-profile">
                            <p class="cap-profile__label">{{ __('simulator.capacity.prof_careful') }}</p>
                            <p class="cap-profile__ratio font-mono" id="prof-ratio-1">35%</p>
                            <p class="cap-profile__capacity font-mono" id="prof-cap-1">—</p>
                            <p class="cap-profile__monthly" id="prof-mo-1">— {{ __('simulator.capacity.per_month') }}</p>
                        </div>
                        <div class="cap-profile cap-profile--recommended">
                            <p class="cap-profile__label">{{ __('simulator.capacity.prof_reco') }}</p>
                            <p class="cap-profile__ratio font-mono" id="prof-ratio-2">43%</p>
                            <p class="cap-profile__capacity font-mono" id="prof-cap-2">—</p>
                            <p class="cap-profile__monthly" id="prof-mo-2">— {{ __('simulator.capacity.per_month') }}</p>
                        </div>
                        <div class="cap-profile">
                            <p class="cap-profile__label">{{ __('simulator.capacity.prof_max') }}</p>
                            <p class="cap-profile__ratio font-mono" id="prof-ratio-3">50%</p>
                            <p class="cap-profile__capacity font-mono" id="prof-cap-3">—</p>
                            <p class="cap-profile__monthly" id="prof-mo-3">— {{ __('simulator.capacity.per_month') }}</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('client.register') }}" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:4px;">
                    {{ __('simulator.capacity.submit_btn') }}
                </a>

            </div>
        </div>

        {{-- Tableau d'analyse --}}
        <div class="sim-amort reveal" style="margin-top:60px;">
            <button class="sim-amort__toggle" id="analysis-toggle" aria-expanded="false">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
                </svg>
                {{ __('simulator.capacity.analysis_btn') }}
                <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M6 9l6 6 6-6"/>
                </svg>
            </button>
            <div class="sim-amort__content" id="analysis-content">
                <div style="overflow-x:auto;padding-top:8px;">
                    <table class="loan-table">
                        <thead>
                            <tr>
                                <th style="text-align:left;">{{ __('simulator.capacity.th_profile') }}</th>
                                <th style="text-align:center;">{{ __('simulator.capacity.th_ratio') }}</th>
                                <th style="text-align:center;">{{ __('simulator.capacity.th_max_mo') }}</th>
                                <th style="text-align:center;">{{ __('simulator.capacity.th_capacity') }}</th>
                                <th style="text-align:center;">{{ __('simulator.capacity.th_interests') }}</th>
                            </tr>
                        </thead>
                        <tbody id="analysis-tbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- CTA --}}
<section class="cta-section" style="padding-block:80px;">
    <div class="container">
        <h2 class="section-title reveal" style="color:#fff;">{{ __('simulator.capacity.cta_title') }}</h2>
        <p class="section-desc reveal stagger-1" style="color:rgba(255,255,255,0.65);max-width:560px;margin-inline:auto;">
            {{ __('simulator.capacity.cta_desc') }}
        </p>
        <div class="cta-section__actions reveal stagger-2">
            <a href="{{ route('client.register') }}" class="btn btn-primary" style="font-size:17px;padding:16px 36px;">{{ __('simulator.submit_file') }}</a>
            <a href="{{ route('contact') }}" class="btn" style="background:rgba(255,255,255,0.1);color:#fff;border:1px solid rgba(255,255,255,0.2);font-size:17px;padding:16px 36px;">{{ __('simulator.advisor') }}</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
(function () {
    'use strict';

    var LOCALE       = '{{ str_replace('_', '-', app()->getLocale()) }}';
    var YEARS_LABEL  = '{{ __('ui.simulator.years') }}';
    var PER_MONTH    = '{{ __('simulator.capacity.per_month') }}';
    var INSUFF       = '{{ __('simulator.capacity.insufficient') }}';
    var GAUGE_NONE   = '{{ __('simulator.capacity.gauge_none') }}';
    var GAUGE_GOOD   = '{{ __('simulator.capacity.gauge_good') }}';
    var GAUGE_OK     = '{{ __('simulator.capacity.gauge_ok') }}';
    var GAUGE_LIMIT  = '{{ __('simulator.capacity.gauge_limit') }}';
    var GAUGE_OVER   = '{{ __('simulator.capacity.gauge_over') }}';
    var PROF_CAREFUL = '{{ __('simulator.capacity.prof_careful') }}';
    var PROF_RECO    = '{{ __('simulator.capacity.prof_reco') }}';
    var PROF_MAX     = '{{ __('simulator.capacity.prof_max') }}';

    function calcCapacity(maxMonthly, annualRate, months) {
        if (maxMonthly <= 0 || months <= 0) return 0;
        if (annualRate === 0) return maxMonthly * months;
        var r = annualRate / 100 / 12;
        return maxMonthly * (1 - Math.pow(1 + r, -months)) / r;
    }

    function fmt(n) {
        if (n <= 0) return INSUFF;
        return new Intl.NumberFormat(LOCALE, { maximumFractionDigits: 0 }).format(Math.round(n)) + '\u202f€';
    }

    function fmtMo(n) {
        if (n <= 0) return '0\u202f€';
        return new Intl.NumberFormat(LOCALE, { maximumFractionDigits: 0 }).format(Math.round(n)) + '\u202f€';
    }

    var ARC_LEN = Math.PI * 90;

    function updateGauge(ratio) {
        var capped = Math.min(ratio, 0.5);
        var fill   = (capped / 0.5) * ARC_LEN;
        var el     = document.getElementById('cap-gauge-fill');
        if (el) el.setAttribute('stroke-dasharray', fill.toFixed(1) + ' ' + ARC_LEN.toFixed(1));

        document.getElementById('gauge-pct').textContent = (ratio * 100).toFixed(1) + '%';

        var color, status;
        if (ratio <= 0)       { color = 'var(--blue)'; status = GAUGE_NONE; }
        else if (ratio < 0.28){ color = '#10b981';     status = GAUGE_GOOD; }
        else if (ratio < 0.40){ color = 'var(--blue)'; status = GAUGE_OK; }
        else if (ratio < 0.50){ color = '#f59e0b';     status = GAUGE_LIMIT; }
        else                  { color = '#ef4444';     status = GAUGE_OVER; }

        if (el) el.setAttribute('stroke', color);
        document.getElementById('gauge-pct').style.color    = color;
        document.getElementById('gauge-status').textContent = status;
        document.getElementById('gauge-status').style.color = color;
    }

    function updateAnalysisTable(income, charges, rate, months, profiles) {
        var tbody = document.getElementById('analysis-tbody');
        if (!tbody) return;
        var rows = profiles.map(function (p) {
            var mo        = Math.max(0, income * p.ratio - charges);
            var cap       = calcCapacity(mo, rate, months);
            var interests = mo > 0 ? ((mo * months) - cap) : 0;
            return '<tr>' +
                '<td><strong>' + p.label + '</strong></td>' +
                '<td class="font-mono" style="text-align:center;color:' + p.color + ';">' + (p.ratio * 100).toFixed(0) + '%</td>' +
                '<td class="font-mono" style="text-align:center;">' + fmtMo(mo) + '</td>' +
                '<td class="font-mono" style="text-align:center;font-weight:700;">' + fmt(cap) + '</td>' +
                '<td class="font-mono" style="text-align:center;">' + (cap > 0 ? fmt(interests) : '—') + '</td>' +
                '</tr>';
        });
        tbody.innerHTML = rows.join('');
    }

    function updateAll() {
        var income  = parseInt(document.getElementById('income').value, 10);
        var charges = parseInt(document.getElementById('charges').value, 10);
        var rate    = parseFloat(document.getElementById('cap-type').value);
        var dur     = parseInt(document.getElementById('cap-duration').value, 10);
        var months  = dur * 12;

        document.getElementById('inc-val').textContent = new Intl.NumberFormat(LOCALE).format(income)   + '\u202f€';
        document.getElementById('chg-val').textContent = new Intl.NumberFormat(LOCALE).format(charges)  + '\u202f€';
        document.getElementById('dur-val').textContent = dur + ' ' + YEARS_LABEL;

        var currentRatio = income > 0 ? charges / income : 0;
        updateGauge(currentRatio);

        var maxMonthly50 = Math.max(0, income * 0.50 - charges);
        var maxCap       = calcCapacity(maxMonthly50, rate, months);
        document.getElementById('cap-main-value').textContent   = fmt(maxCap);
        document.getElementById('cap-main-monthly').textContent = fmtMo(maxMonthly50) + ' ' + PER_MONTH;

        var profiles = [
            { ratio: 0.35, id: 1, label: PROF_CAREFUL, color: '#10b981' },
            { ratio: 0.43, id: 2, label: PROF_RECO,    color: 'var(--blue)' },
            { ratio: 0.50, id: 3, label: PROF_MAX,     color: '#ef4444' },
        ];

        profiles.forEach(function (p) {
            var mo  = Math.max(0, income * p.ratio - charges);
            var cap = calcCapacity(mo, rate, months);
            document.getElementById('prof-cap-' + p.id).textContent = fmt(cap);
            document.getElementById('prof-mo-'  + p.id).textContent = fmtMo(mo) + ' ' + PER_MONTH;
        });

        updateAnalysisTable(income, charges, rate, months, [
            { label: PROF_CAREFUL, ratio: 0.35, color: '#10b981' },
            { label: PROF_RECO,    ratio: 0.43, color: 'var(--blue)' },
            { label: PROF_MAX,     ratio: 0.50, color: '#ef4444' },
        ]);
    }

    var toggleBtn    = document.getElementById('analysis-toggle');
    var analysisBody = document.getElementById('analysis-content');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            var isOpen = analysisBody.classList.toggle('open');
            toggleBtn.setAttribute('aria-expanded', String(isOpen));
        });
    }

    ['income', 'charges', 'cap-type', 'cap-duration'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener(el.tagName === 'SELECT' ? 'change' : 'input', updateAll);
    });

    updateAll();
})();
</script>
@endsection
