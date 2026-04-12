@extends('layouts.app')
@section('title', __('simulator.compare.meta_title'))
@section('description', __('simulator.compare.meta_desc'))
@section('styles')
<link rel="stylesheet" href="{{ asset('css/simulator.css') }}">
@endsection

@section('content')

{{-- Hero --}}
<section class="sim-hero">
    <div class="container sim-hero__inner">
        <div class="section-header" style="margin-bottom:0;">
            <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('simulator.free_tool') }}</span>
            <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('simulator.compare.hero_title') }}</h1>
            <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;margin-top:12px;">
                {{ __('simulator.compare.hero_desc') }}
            </p>
        </div>
        <nav class="sim-tools-nav reveal stagger-3" aria-label="{{ __('simulator.nav_sim') }}">
            <a href="{{ route('simulator.index') }}" class="sim-tool-link">{{ __('simulator.nav_sim') }}</a>
            <a href="{{ route('simulator.compare') }}" class="sim-tool-link active" aria-current="page">{{ __('simulator.nav_comp') }}</a>
            <a href="{{ route('simulator.capacity') }}" class="sim-tool-link">{{ __('simulator.nav_cap') }}</a>
        </nav>
    </div>
</section>

{{-- Comparateur --}}
<section class="sim-main">
    <div class="container">

        <div class="compare-grid reveal">

            @php
            $scenarios = [
                1 => ['type' => '1.9', 'amt' => 200000, 'dur' => 20],
                2 => ['type' => '2.5', 'amt' => 25000,  'dur' => 5],
                3 => ['type' => '3.2', 'amt' => 10000,  'dur' => 3],
            ];
            $loan_types = [
                '1.9' => '🏠 ' . __('simulator.type_immo')  . ' — 1.9%',
                '2.5' => '🚗 ' . __('simulator.type_auto')  . ' — 2.5%',
                '3.2' => '💳 ' . __('simulator.type_perso') . ' — 3.2%',
                '2.8' => '🏢 ' . __('simulator.type_pro')   . ' — 2.8%',
                '2.3' => '🌾 ' . __('simulator.type_agri')  . ' — 2.3%',
                '4.5' => '🤲 ' . __('simulator.type_micro') . ' — 4.5%',
            ];
            @endphp

            @foreach($scenarios as $i => $s)
            <div class="compare-col" id="col-{{ $i }}">
                <div class="compare-col__head">
                    <span class="compare-col__num font-mono">{{ __('simulator.compare.scenario') }} {{ $i }}</span>
                    <span class="compare-badge" id="badge-{{ $i }}">{{ __('simulator.compare.best_rate') }}</span>
                </div>

                <div class="sim-group">
                    <div class="sim-label"><span>{{ __('simulator.compare.loan_type') }}</span></div>
                    <select class="compare-select" id="type-{{ $i }}" aria-label="{{ __('simulator.compare.loan_type') }} {{ $i }}">
                        @foreach($loan_types as $rate => $label)
                        <option value="{{ $rate }}" {{ $rate == $s['type'] ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sim-group">
                    <div class="sim-label">
                        <span>{{ __('simulator.compare.amount') }}</span>
                        <span class="font-mono compare-val" id="amt-val-{{ $i }}" style="color:var(--blue);font-size:18px;">
                            {{ number_format($s['amt'], 0, ',', ' ') }} €
                        </span>
                    </div>
                    <input type="range" class="sim-slider" id="amt-{{ $i }}"
                        min="5000" max="500000" step="5000" value="{{ $s['amt'] }}"
                        aria-label="{{ __('simulator.compare.amount') }} {{ $i }}">
                    <div class="sim-range-labels"><span>5 000 €</span><span>500 000 €</span></div>
                </div>

                <div class="sim-group">
                    <div class="sim-label">
                        <span>{{ __('simulator.compare.duration') }}</span>
                        <span class="font-mono compare-val" id="dur-val-{{ $i }}" style="color:var(--blue);font-size:18px;">
                            {{ $s['dur'] }} {{ __('ui.simulator.years') }}
                        </span>
                    </div>
                    <input type="range" class="sim-slider" id="dur-{{ $i }}"
                        min="1" max="30" step="1" value="{{ $s['dur'] }}"
                        aria-label="{{ __('simulator.compare.duration') }} {{ $i }}">
                    <div class="sim-range-labels"><span>1 {{ __('ui.simulator.years') }}</span><span>30 {{ __('ui.simulator.years') }}</span></div>
                </div>

                <div class="compare-result-card">
                    <p class="compare-result-card__label">{{ __('simulator.compare.monthly') }}</p>
                    <p class="compare-result-card__value font-mono" id="monthly-{{ $i }}">—</p>
                </div>

                <div class="compare-mini-stats">
                    <div>
                        <span>{{ __('simulator.compare.total_cost') }}</span>
                        <span class="font-mono" id="total-{{ $i }}">—</span>
                    </div>
                    <div>
                        <span>{{ __('simulator.compare.interests') }}</span>
                        <span class="font-mono" id="interests-{{ $i }}">—</span>
                    </div>
                    <div>
                        <span>{{ __('simulator.compare.taeg') }}</span>
                        <span class="font-mono" id="rate-{{ $i }}">—</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Tableau comparatif récap --}}
        <div class="sim-amort reveal" style="margin-top:48px;">
            <button class="sim-amort__toggle" id="table-toggle" aria-expanded="false">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
                </svg>
                {{ __('simulator.compare.recap_toggle') }}
                <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M6 9l6 6 6-6"/>
                </svg>
            </button>
            <div class="sim-amort__content" id="table-content">
                <div style="overflow-x:auto;padding-top:8px;">
                    <table class="loan-table">
                        <thead>
                            <tr>
                                <th style="text-align:left;">{{ __('simulator.compare.th_criteria') }}</th>
                                <th style="text-align:center;">{{ __('simulator.compare.scenario') }} 1</th>
                                <th style="text-align:center;">{{ __('simulator.compare.scenario') }} 2</th>
                                <th style="text-align:center;">{{ __('simulator.compare.scenario') }} 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach([
                                ['label_key' => 'row_monthly',   'key' => 'monthly'],
                                ['label_key' => 'row_total',     'key' => 'total'],
                                ['label_key' => 'row_interests', 'key' => 'interests'],
                                ['label_key' => 'row_taeg',      'key' => 'rate'],
                            ] as $row)
                            <tr>
                                <td>{{ __('simulator.compare.' . $row['label_key']) }}</td>
                                @foreach([1,2,3] as $i)
                                <td class="font-mono" id="tb-{{ $row['key'] }}-{{ $i }}" style="text-align:center;">—</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="reveal" style="text-align:center;margin-top:48px;display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('client.register') }}" class="btn btn-primary" style="font-size:16px;padding:15px 32px;">
                {{ __('simulator.compare.btn_file') }}
            </a>
            <a href="{{ route('simulator.index') }}" class="btn btn-outline" style="font-size:16px;padding:15px 32px;">
                {{ __('simulator.compare.btn_sim') }}
            </a>
            <a href="{{ route('simulator.capacity') }}" class="btn btn-outline" style="font-size:16px;padding:15px 32px;">
                {{ __('simulator.compare.btn_cap') }}
            </a>
        </div>

    </div>
</section>

{{-- CTA --}}
<section class="cta-section" style="padding-block:80px;">
    <div class="container">
        <h2 class="section-title reveal" style="color:#fff;">{{ __('simulator.compare.cta_title') }}</h2>
        <p class="section-desc reveal stagger-1" style="color:rgba(255,255,255,0.65);max-width:540px;margin-inline:auto;">
            {{ __('simulator.compare.cta_desc') }}
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

    var YEARS_LABEL = '{{ __('ui.simulator.years') }}';

    function calcMonthly(principal, annualRate, months) {
        if (months <= 0 || principal <= 0) return 0;
        if (annualRate === 0) return principal / months;
        var r = annualRate / 100 / 12;
        return principal * r * Math.pow(1 + r, months) / (Math.pow(1 + r, months) - 1);
    }

    function fmt(n) {
        return new Intl.NumberFormat('{{ str_replace('_', '-', app()->getLocale()) }}', { maximumFractionDigits: 0 }).format(Math.round(n)) + '\u202f€';
    }

    function updateCol(i) {
        var rate   = parseFloat(document.getElementById('type-' + i).value);
        var amt    = parseInt(document.getElementById('amt-' + i).value, 10);
        var dur    = parseInt(document.getElementById('dur-' + i).value, 10);
        var months = dur * 12;
        var monthly    = calcMonthly(amt, rate, months);
        var totalCost  = monthly * months;
        var interests  = totalCost - amt;

        document.getElementById('amt-val-' + i).textContent = new Intl.NumberFormat('{{ str_replace('_', '-', app()->getLocale()) }}').format(amt) + '\u202f€';
        document.getElementById('dur-val-' + i).textContent = dur + ' ' + YEARS_LABEL;

        var mFmt = fmt(monthly);
        var tFmt = fmt(totalCost);
        var iFmt = fmt(interests);
        var rFmt = rate.toFixed(2) + '%';

        document.getElementById('monthly-'   + i).textContent = mFmt;
        document.getElementById('total-'     + i).textContent = tFmt;
        document.getElementById('interests-' + i).textContent = iFmt;
        document.getElementById('rate-'      + i).textContent = rFmt;

        document.getElementById('tb-monthly-'   + i).textContent = mFmt;
        document.getElementById('tb-total-'     + i).textContent = tFmt;
        document.getElementById('tb-interests-' + i).textContent = iFmt;
        document.getElementById('tb-rate-'      + i).textContent = rFmt;

        highlightBest();
    }

    function highlightBest() {
        var rates  = [1, 2, 3].map(function (i) { return parseFloat(document.getElementById('type-' + i).value); });
        var minRate = Math.min.apply(null, rates);
        [1, 2, 3].forEach(function (i) {
            var badge = document.getElementById('badge-' + i);
            var col   = document.getElementById('col-' + i);
            var isMin = parseFloat(document.getElementById('type-' + i).value) === minRate;
            badge.classList.toggle('visible', isMin);
            col.classList.toggle('compare-col--best', isMin);
        });
    }

    var toggleBtn    = document.getElementById('table-toggle');
    var tableContent = document.getElementById('table-content');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            var isOpen = tableContent.classList.toggle('open');
            toggleBtn.setAttribute('aria-expanded', String(isOpen));
        });
    }

    [1, 2, 3].forEach(function (i) {
        document.getElementById('type-' + i).addEventListener('change', function () { updateCol(i); });
        document.getElementById('amt-'  + i).addEventListener('input',  function () { updateCol(i); });
        document.getElementById('dur-'  + i).addEventListener('input',  function () { updateCol(i); });
        updateCol(i);
    });
})();
</script>
@endsection
