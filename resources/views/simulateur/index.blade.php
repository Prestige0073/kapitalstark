@extends('layouts.app')

@section('title', __('simulator.index.meta_title'))
@section('description', __('simulator.index.meta_desc'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/simulator.css') }}">
@endsection

@section('content')

{{-- Hero --}}
<section class="sim-hero">
    <div class="container sim-hero__inner">
        <div class="section-header" style="margin-bottom:0;">
            <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('simulator.free_tool') }}</span>
            <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('simulator.index.hero_title') }}</h1>
            <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;margin-top:12px;">{{ __('simulator.index.hero_desc') }}</p>
        </div>
        <nav class="sim-tools-nav reveal stagger-3" aria-label="{{ __('simulator.nav_sim') }}">
            <a href="{{ route('simulator.index') }}" class="sim-tool-link active" aria-current="page">{{ __('simulator.nav_sim') }}</a>
            <a href="{{ route('simulator.compare') }}" class="sim-tool-link">{{ __('simulator.nav_comp') }}</a>
            <a href="{{ route('simulator.capacity') }}" class="sim-tool-link">{{ __('simulator.nav_cap') }}</a>
        </nav>
    </div>
</section>

{{-- Simulateur principal --}}
<section class="sim-main">
    <div class="container">

        {{-- Onglets type de prêt --}}
        <div class="sim-types reveal">
            @foreach([
                ['key'=>'immo', 'icon'=>'🏠','label_key'=>'type_immo', 'rate'=>'1.9'],
                ['key'=>'auto', 'icon'=>'🚗','label_key'=>'type_auto', 'rate'=>'2.5'],
                ['key'=>'perso','icon'=>'💳','label_key'=>'type_perso','rate'=>'3.2'],
                ['key'=>'pro',  'icon'=>'🏢','label_key'=>'type_pro',  'rate'=>'2.8'],
                ['key'=>'agri', 'icon'=>'🌾','label_key'=>'type_agri', 'rate'=>'2.3'],
            ] as $t)
            <button class="sim-type-tab {{ $t['key'] === 'immo' ? 'active' : '' }}" data-type="{{ $t['key'] }}" data-rate="{{ $t['rate'] }}">
                <span class="sim-type-tab__icon">{{ $t['icon'] }}</span>
                <span class="sim-type-tab__label">{{ __('simulator.' . $t['label_key']) }}</span>
                <span class="sim-type-tab__rate font-mono">{{ $t['rate'] }}%</span>
            </button>
            @endforeach
        </div>

        <div class="sim-layout">

            {{-- Panneau gauche : contrôles --}}
            <div class="sim-controls reveal stagger-1">
                <h3 style="margin-bottom:32px;font-size:18px;">{{ __('simulator.index.params') }}</h3>

                {{-- Montant --}}
                <div class="sim-group">
                    <div class="sim-label">
                        <span>{{ __('simulator.index.amount') }}</span>
                        <span id="fs-amount-val" class="font-mono" style="color:var(--blue);font-size:20px;">200 000 €</span>
                    </div>
                    <input type="range" class="sim-slider" id="fs-amount" min="5000" max="1000000" step="5000" value="200000" aria-label="{{ __('simulator.index.amount') }}">
                    <div class="sim-range-labels"><span>5 000 €</span><span>1 000 000 €</span></div>
                </div>

                {{-- Durée --}}
                <div class="sim-group">
                    <div class="sim-label">
                        <span>{{ __('simulator.index.duration') }}</span>
                        <span id="fs-dur-val" class="font-mono" style="color:var(--blue);font-size:20px;">20 {{ __('ui.simulator.years') }}</span>
                    </div>
                    <input type="range" class="sim-slider" id="fs-duration" min="1" max="30" step="1" value="20" aria-label="{{ __('simulator.index.duration') }}">
                    <div class="sim-range-labels"><span>1 {{ __('ui.simulator.years') }}</span><span>30 {{ __('ui.simulator.years') }}</span></div>
                </div>

                {{-- Apport --}}
                <div class="sim-group">
                    <div class="sim-label">
                        <span>{{ __('simulator.index.down_payment') }}</span>
                        <span id="fs-apport-val" class="font-mono" style="color:var(--blue);font-size:20px;">20 000 €</span>
                    </div>
                    <input type="range" class="sim-slider" id="fs-apport" min="0" max="200000" step="1000" value="20000" aria-label="{{ __('simulator.index.down_payment') }}">
                    <div class="sim-range-labels"><span>0 €</span><span>200 000 €</span></div>
                </div>

                {{-- Assurance --}}
                <div class="sim-group">
                    <div class="sim-label">
                        <span>{{ __('simulator.index.insurance') }}</span>
                        <span id="fs-ins-val" class="font-mono" style="color:var(--blue);font-size:20px;">0.36%</span>
                    </div>
                    <input type="range" class="sim-slider" id="fs-insurance" min="0" max="150" step="1" value="36" aria-label="{{ __('simulator.index.insurance') }}">
                    <div class="sim-range-labels"><span>0%</span><span>1.5%</span></div>
                </div>

                <div style="background:rgba(38,123,241,0.06);border-radius:var(--radius-md);padding:16px;margin-top:8px;">
                    <p style="font-size:13px;color:var(--text-muted);line-height:1.6;">
                        <strong style="color:var(--blue);">{{ __('simulator.index.taeg_label') }} </strong>
                        <span id="fs-rate-display" class="font-mono">1.90%</span> —
                        {{ __('simulator.index.taeg_note') }}
                    </p>
                </div>
            </div>

            {{-- Panneau droite : résultats --}}
            <div class="sim-results-panel reveal stagger-2">

                {{-- Résultat principal --}}
                <div class="sim-main-result">
                    <p class="sim-main-result__label">{{ __('simulator.index.monthly') }}</p>
                    <p class="sim-main-result__value font-mono" id="fs-monthly">850 €</p>
                    <p class="sim-main-result__sub" id="fs-ins-sub">{{ str_replace(':amount', '<span id="fs-ins-monthly">52 €</span>', __('simulator.index.insurance_inc')) }}</p>
                </div>

                {{-- Grille stats --}}
                <div class="sim-stats-grid">
                    <div class="sim-stat">
                        <span class="sim-stat__label">{{ __('simulator.index.capital') }}</span>
                        <span class="sim-stat__value font-mono" id="fs-capital">180 000 €</span>
                    </div>
                    <div class="sim-stat">
                        <span class="sim-stat__label">{{ __('simulator.index.total_cost') }}</span>
                        <span class="sim-stat__value font-mono" id="fs-total">204 000 €</span>
                    </div>
                    <div class="sim-stat">
                        <span class="sim-stat__label">{{ __('simulator.index.interests') }}</span>
                        <span class="sim-stat__value font-mono" id="fs-interests">24 000 €</span>
                    </div>
                    <div class="sim-stat">
                        <span class="sim-stat__label">{{ __('simulator.index.ins_cost') }}</span>
                        <span class="sim-stat__value font-mono" id="fs-ins-total">12 480 €</span>
                    </div>
                </div>

                {{-- Graphique --}}
                <div class="sim-chart-wrap">
                    <p style="font-size:13px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:16px;">{{ __('simulator.index.chart_title') }}</p>
                    <div class="sim-chart">
                        <svg id="sim-donut" viewBox="0 0 200 200" class="sim-donut" aria-label="{{ __('simulator.index.chart_title') }}">
                            <circle class="sim-donut__bg" cx="100" cy="100" r="70" fill="none" stroke="var(--cream)" stroke-width="30"/>
                            <circle class="sim-donut__capital" cx="100" cy="100" r="70" fill="none" stroke="var(--blue)" stroke-width="30"
                                stroke-dasharray="439.8 0" stroke-dashoffset="0" transform="rotate(-90 100 100)"/>
                            <circle class="sim-donut__interests" cx="100" cy="100" r="70" fill="none" stroke="var(--gold)" stroke-width="30"
                                stroke-dasharray="0 439.8" stroke-dashoffset="0" transform="rotate(-90 100 100)"/>
                            <circle class="sim-donut__insurance" cx="100" cy="100" r="70" fill="none" stroke="var(--blue-light)" stroke-width="30"
                                stroke-dasharray="0 439.8" stroke-dashoffset="0" transform="rotate(-90 100 100)"/>
                        </svg>
                        <div class="sim-donut-legend">
                            <span class="sim-donut-legend__item" style="--c:var(--blue);">{{ __('simulator.index.legend_cap') }}</span>
                            <span class="sim-donut-legend__item" style="--c:var(--gold);">{{ __('simulator.index.legend_int') }}</span>
                            <span class="sim-donut-legend__item" style="--c:var(--blue-light);">{{ __('simulator.index.legend_ins') }}</span>
                        </div>
                    </div>
                </div>

                <a href="/contact/rdv" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px;">
                    {{ __('simulator.index.get_offer') }}
                </a>
            </div>

        </div>

        {{-- Tableau d'amortissement --}}
        <div class="sim-amort reveal" style="margin-top:60px;">
            <button class="sim-amort__toggle" id="amort-toggle" aria-expanded="false">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                {{ __('simulator.index.amort_toggle') }}
                <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
            </button>
            <div class="sim-amort__content" id="amort-content">
                <div style="overflow-x:auto;">
                    <table class="loan-table" id="amort-table">
                        <thead>
                            <tr>
                                <th>{{ __('simulator.index.th_month') }}</th>
                                <th>{{ __('simulator.index.th_monthly') }}</th>
                                <th>{{ __('simulator.index.th_capital') }}</th>
                                <th>{{ __('simulator.index.th_interests') }}</th>
                                <th>{{ __('simulator.index.th_remaining') }}</th>
                            </tr>
                        </thead>
                        <tbody id="amort-tbody"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- CTA --}}
<section class="cta-section" style="padding-block:80px;">
    <div class="container">
        <h2 class="section-title reveal" style="color:#fff;">{{ __('simulator.index.cta_title') }}</h2>
        <p class="section-desc reveal stagger-1" style="color:rgba(255,255,255,0.65);max-width:560px;margin-inline:auto;">{{ __('simulator.index.cta_desc') }}</p>
        <div class="cta-section__actions reveal stagger-2">
            <a href="/espace-client" class="btn btn-primary" style="font-size:17px;padding:16px 36px;">{{ __('simulator.submit_file') }}</a>
            <a href="/contact" class="btn" style="background:rgba(255,255,255,0.1);color:#fff;border:1px solid rgba(255,255,255,0.2);font-size:17px;padding:16px 36px;">{{ __('simulator.advisor') }}</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('js/simulator.js') }}"></script>
@endsection
