@extends('layouts.app')

@section('title', __('home.meta_title'))
@section('description', __('home.meta_desc'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')

{{-- ══════════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════════ --}}
<section class="hero">
    <div class="container hero__inner">

        {{-- Gauche --}}
        <div class="hero__content">
            <div class="hero__label reveal">
                <span class="hero__label-dot"></span>
                {{ __('home.hero.label') }}
            </div>

            <h1 class="hero__title reveal stagger-1">
                {{ __('home.hero.title_1') }}<br>
                <span>{{ __('home.hero.title_em') }}</span> {{ __('home.hero.title_2') }}
            </h1>

            <p class="hero__desc reveal stagger-2">
                {{ __('home.hero.desc') }}
            </p>

            <div class="hero__actions reveal stagger-3">
                <a href="/simulateur" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                    {{ __('home.hero.cta_sim') }}
                </a>
                <a href="/prets" class="btn btn-outline" style="color:#fff;border-color:rgba(255,255,255,0.3);">
                    {{ __('home.hero.cta_offers') }}
                </a>
            </div>

            <div class="hero__trust reveal stagger-4">
                <div class="hero__trust-item">
                    <span class="hero__trust-value">+50 000</span>
                    <span class="hero__trust-label">{{ __('home.hero.trust_clients') }}</span>
                </div>
                <div class="hero__trust-item">
                    <span class="hero__trust-value">1.9%</span>
                    <span class="hero__trust-label">{{ __('home.hero.trust_rate') }}</span>
                </div>
                <div class="hero__trust-item">
                    <span class="hero__trust-value">24h</span>
                    <span class="hero__trust-label">{{ __('home.hero.trust_response') }}</span>
                </div>
                <div class="hero__trust-item">
                    <span class="hero__trust-value">98%</span>
                    <span class="hero__trust-label">{{ __('home.hero.trust_satis') }}</span>
                </div>
            </div>
        </div>

        {{-- Droite — Carte visuelle --}}
        <div class="hero__visual reveal stagger-2">
            <div class="hero__card-main">
                <div class="hero__card-header">
                    <span class="hero__card-title">{{ __('home.hero.card_title') }}</span>
                    <span class="hero__card-badge">{{ __('home.hero.card_eligible') }}</span>
                </div>

                <div class="hero__rate">
                    <div>
                        <span class="hero__rate-value">1.9</span>
                        <span class="hero__rate-suffix">%</span>
                    </div>
                    <p class="hero__rate-label">{{ __('home.hero.card_taeg') }}</p>
                </div>

                <div class="hero__progress">
                    <div class="hero__progress-label">
                        <span>{{ __('home.hero.card_capacity') }}</span>
                        <span style="font-family:var(--font-mono);color:var(--blue-light);">68%</span>
                    </div>
                    <div class="hero__progress-bar">
                        <div class="hero__progress-fill"></div>
                    </div>
                </div>

                <div class="hero__card-row">
                    <div class="hero__card-stat">
                        <strong>850 €</strong>
                        <small>{{ __('home.hero.card_per_month') }}</small>
                    </div>
                    <div class="hero__card-stat">
                        <strong>240</strong>
                        <small>{{ __('ui.simulator.months') }}</small>
                    </div>
                    <div class="hero__card-stat">
                        <strong>200k</strong>
                        <small>{{ __('home.hero.card_amount') }}</small>
                    </div>
                </div>
            </div>

            {{-- Badges flottants --}}
            <div class="hero__float hero__float--1">
                <div class="hero__float-icon">🏦</div>
                <div class="hero__float-text">
                    <strong>{{ __('home.hero.float1_title') }}</strong>
                    <small>{{ __('home.hero.float1_sub') }}</small>
                </div>
            </div>

            <div class="hero__float hero__float--2">
                <div class="hero__float-icon">🔒</div>
                <div class="hero__float-text">
                    <strong>{{ __('home.hero.float2_title') }}</strong>
                    <small>{{ __('home.hero.float2_sub') }}</small>
                </div>
            </div>
        </div>

    </div><!-- /.container -->

    {{-- Indicateur scroll --}}
    <div class="hero__scroll" aria-hidden="true">
        <div class="hero__scroll-mouse">
            <div class="hero__scroll-dot"></div>
        </div>
        <span>{{ __('home.hero.scroll') }}</span>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     BARRE DE CONFIANCE / PARTENAIRES
═══════════════════════════════════════════════════════════ --}}
<div class="trust-bar">
    <p class="trust-bar__label">{{ __('home.partners.label') }}</p>
    <div style="overflow:hidden;">
        <div class="trust-bar__track">
            @php
            $partners = [
                ['file' => 'bnp-paribas.svg',     'name' => 'BNP Paribas'],
                ['file' => 'societe-generale.svg', 'name' => 'Société Générale'],
                ['file' => 'credit-agricole.svg',  'name' => 'Crédit Agricole'],
                ['file' => 'caisse-epargne.svg',   'name' => 'Caisse d\'Épargne'],
                ['file' => 'banque-postale.svg',   'name' => 'La Banque Postale'],
                ['file' => 'axa.svg',              'name' => 'AXA'],
                ['file' => 'lcl.svg',              'name' => 'LCL'],
                ['file' => 'credit-mutuel.svg',    'name' => 'Crédit Mutuel'],
                // Banques portugaises — pays du siège social (Lisboa)
                ['file' => 'cgd.svg',              'name' => 'Caixa Geral de Depósitos'],
                ['file' => 'millennium-bcp.svg',   'name' => 'Millennium BCP'],
                ['file' => 'novo-banco.svg',       'name' => 'Novo Banco'],
                ['file' => 'bpi.svg',              'name' => 'BPI'],
            ];
            @endphp
            @foreach(array_merge($partners, $partners) as $p)
            <div class="trust-bar__logo">
                <img src="{{ asset('img/partners/' . $p['file']) }}"
                     alt="{{ $p['name'] }}"
                     class="trust-bar__logo-img"
                     loading="lazy">
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     NOS TYPES DE PRÊTS
═══════════════════════════════════════════════════════════ --}}
<section class="loans">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('home.loans.label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('home.loans.title') }}</h2>
            <p class="section-desc reveal stagger-2">{{ __('home.loans.desc') }}</p>
        </div>

        <div class="loans__bento">

            {{-- Carte featured : Immobilier --}}
            <div class="loan-card loan-card--featured card reveal">
                <div class="loan-card__icon-wrap">🏠</div>
                <p class="loan-card__title">{{ __('ui.nav.loan_mortgage') }}</p>
                <div class="loan-card__big-rate">1.9<span style="font-size:28px;opacity:.6">%</span></div>
                <p class="loan-card__big-label">{{ __('home.loans.from') }}</p>
                <p class="loan-card__desc" style="margin-top:16px;">{{ __('home.loans.mortgage_desc') }}</p>
                <a href="/prets/immobilier" class="loan-card__link" style="margin-top:auto;padding-top:24px;">
                    {{ __('home.loans.learn_more') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- Automobile --}}
            <div class="loan-card card reveal stagger-1">
                <div class="loan-card__icon-wrap">🚗</div>
                <p class="loan-card__title">{{ __('ui.nav.loan_auto') }}</p>
                <span class="loan-card__rate">{{ __('home.loans.auto_rate') }}</span>
                <p class="loan-card__desc">{{ __('home.loans.auto_desc') }}</p>
                <a href="/prets/automobile" class="loan-card__link">
                    {{ __('home.loans.discover') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- Personnel --}}
            <div class="loan-card card reveal stagger-2">
                <div class="loan-card__icon-wrap">💳</div>
                <p class="loan-card__title">{{ __('ui.nav.loan_personal') }}</p>
                <span class="loan-card__rate">{{ __('home.loans.personal_rate') }}</span>
                <p class="loan-card__desc">{{ __('home.loans.personal_desc') }}</p>
                <a href="/prets/personnel" class="loan-card__link">
                    {{ __('home.loans.discover') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- Entreprise --}}
            <div class="loan-card card reveal stagger-1">
                <div class="loan-card__icon-wrap">🏢</div>
                <p class="loan-card__title">{{ __('ui.nav.loan_business') }}</p>
                <span class="loan-card__rate">{{ __('home.loans.business_rate') }}</span>
                <p class="loan-card__desc">{{ __('home.loans.business_desc') }}</p>
                <a href="/prets/entreprise" class="loan-card__link">
                    {{ __('home.loans.discover') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- Agricole --}}
            <div class="loan-card card reveal stagger-2">
                <div class="loan-card__icon-wrap">🌾</div>
                <p class="loan-card__title">{{ __('ui.nav.loan_agri') }}</p>
                <span class="loan-card__rate">{{ __('home.loans.agri_rate') }}</span>
                <p class="loan-card__desc">{{ __('home.loans.agri_desc') }}</p>
                <a href="/prets/agricole" class="loan-card__link">
                    {{ __('home.loans.discover') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- Microcrédit --}}
            <div class="loan-card card reveal stagger-3">
                <div class="loan-card__icon-wrap">🌱</div>
                <p class="loan-card__title">{{ __('ui.nav.loan_micro') }}</p>
                <span class="loan-card__rate">{{ __('home.loans.micro_rate') }}</span>
                <p class="loan-card__desc">{{ __('home.loans.micro_desc') }}</p>
                <a href="/prets/microcredit" class="loan-card__link">
                    {{ __('home.loans.discover') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     POURQUOI KAPITALSTARK
═══════════════════════════════════════════════════════════ --}}
<section class="why">
    <div class="container why__inner">

        {{-- Visuel Lottie --}}
        <div class="why__visual reveal">
            <div class="why__img-wrap" style="background:none;box-shadow:none;overflow:visible;position:relative;">
                <svg viewBox="0 0 400 380" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:460px;height:auto;margin:auto;display:block;" aria-hidden="true">
                    <!-- Cercles de fond -->
                    <circle cx="200" cy="200" r="175" fill="rgba(38,123,241,0.05)" stroke="rgba(38,123,241,0.1)" stroke-width="1.5"/>
                    <circle cx="200" cy="200" r="125" fill="rgba(38,123,241,0.07)" stroke="rgba(38,123,241,0.12)" stroke-width="1.5"/>
                    <!-- Grille -->
                    <line x1="40" y1="110" x2="360" y2="110" stroke="rgba(38,123,241,0.2)" stroke-width="1"/>
                    <line x1="40" y1="160" x2="360" y2="160" stroke="rgba(38,123,241,0.2)" stroke-width="1"/>
                    <line x1="40" y1="210" x2="360" y2="210" stroke="rgba(38,123,241,0.2)" stroke-width="1"/>
                    <line x1="40" y1="260" x2="360" y2="260" stroke="rgba(38,123,241,0.2)" stroke-width="1"/>
                    <!-- Zone remplie -->
                    <path d="M40,280 L100,230 L160,245 L220,168 L280,178 L340,108 L360,112 L360,300 L40,300 Z"
                        fill="rgba(38,123,241,0.12)"/>
                    <!-- Courbe principale (toujours visible) -->
                    <polyline points="40,280 100,230 160,245 220,168 280,178 340,108"
                        fill="none" stroke="#267BF1" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <!-- Points de données -->
                    <circle cx="100" cy="230" r="5" fill="#267BF1"/>
                    <circle cx="160" cy="245" r="5" fill="#267BF1"/>
                    <circle cx="220" cy="168" r="5" fill="#267BF1"/>
                    <circle cx="280" cy="178" r="5" fill="#267BF1"/>
                    <!-- Point final pulsant -->
                    <circle cx="340" cy="108" r="6" fill="#267BF1" class="guide-svg-pulse"/>
                    <circle cx="340" cy="108" r="14" fill="rgba(38,123,241,0.2)" class="guide-svg-pulse-ring"/>
                    <!-- Étiquettes axe Y -->
                    <text x="2" y="114" font-size="12" fill="rgba(26,37,64,0.45)" font-family="monospace">+20%</text>
                    <text x="8" y="215" font-size="12" fill="rgba(26,37,64,0.45)" font-family="monospace">0%</text>
                    <!-- Badge +12% -->
                    <rect x="280" y="68" width="76" height="28" rx="8" fill="rgba(22,163,74,0.15)" stroke="rgba(22,163,74,0.4)" stroke-width="1.5"/>
                    <text x="318" y="87" text-anchor="middle" font-size="13" font-weight="700" fill="#15803d" font-family="monospace">+12%</text>
                    <!-- Axe X labels -->
                    <text x="35" y="320" font-size="11" fill="rgba(26,37,64,0.3)" font-family="monospace">Jan</text>
                    <text x="93" y="320" font-size="11" fill="rgba(26,37,64,0.3)" font-family="monospace">Mar</text>
                    <text x="153" y="320" font-size="11" fill="rgba(26,37,64,0.3)" font-family="monospace">Mai</text>
                    <text x="213" y="320" font-size="11" fill="rgba(26,37,64,0.3)" font-family="monospace">Juil</text>
                    <text x="273" y="320" font-size="11" fill="rgba(26,37,64,0.3)" font-family="monospace">Sep</text>
                    <text x="333" y="320" font-size="11" fill="rgba(26,37,64,0.3)" font-family="monospace">Nov</text>
                </svg>
            </div>
            <div class="why__badge-float">
                <div class="why__badge-icon">⭐</div>
                <div>
                    <strong class="why__badge-value">4.8/5</strong>
                    <span class="why__badge-label">{{ __('home.why.rating') }}</span>
                </div>
            </div>
        </div>

        {{-- Contenu --}}
        <div class="why__content">
            <span class="section-label reveal">{{ __('home.why.label') }}</span>
            <h2 class="section-title reveal stagger-1" style="margin-top:12px;">{{ __('home.why.title') }}</h2>
            <p class="section-desc reveal stagger-2" style="text-align:left;">{{ __('home.why.desc') }}</p>

            <div class="why__features">
                @foreach([
                    ['icon'=>'⚡','title_key'=>'f1_title','desc_key'=>'f1_desc'],
                    ['icon'=>'🔐','title_key'=>'f2_title','desc_key'=>'f2_desc'],
                    ['icon'=>'🎯','title_key'=>'f3_title','desc_key'=>'f3_desc'],
                    ['icon'=>'💬','title_key'=>'f4_title','desc_key'=>'f4_desc'],
                    ['icon'=>'📱','title_key'=>'f5_title','desc_key'=>'f5_desc'],
                    ['icon'=>'🔄','title_key'=>'f6_title','desc_key'=>'f6_desc'],
                ] as $i => $f)
                <div class="why__feature reveal stagger-{{ ($i % 3) + 1 }}">
                    <div class="why__feature-icon">{{ $f['icon'] }}</div>
                    <div class="why__feature-body">
                        <h4>{{ __('home.why.' . $f['title_key']) }}</h4>
                        <p>{{ __('home.why.' . $f['desc_key']) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     SIMULATEUR RAPIDE
═══════════════════════════════════════════════════════════ --}}
<section class="simulator">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-label">{{ __('home.sim.label') }}</span>
            <h2 class="section-title">{{ __('home.sim.title') }}</h2>
            <p class="section-desc">{{ __('home.sim.desc') }}</p>
        </div>

        <div class="simulator__grid">

            {{-- Formulaire --}}
            <div class="simulator__form reveal stagger-1">
                <div class="sim-tabs">
                    <button class="sim-tab active" data-type="immo">{{ __('home.sim.tab_immo') }}</button>
                    <button class="sim-tab" data-type="auto">{{ __('home.sim.tab_auto') }}</button>
                    <button class="sim-tab" data-type="perso">{{ __('home.sim.tab_perso') }}</button>
                    <button class="sim-tab" data-type="pro">{{ __('home.sim.tab_pro') }}</button>
                </div>

                {{-- Montant --}}
                <div class="sim-group">
                    <div class="sim-label">
                        <span>{{ __('ui.simulator.amount') }}</span>
                        <span id="sim-amount-val">200 000 €</span>
                    </div>
                    <input type="range" class="sim-slider" id="sim-amount"
                        min="5000" max="500000" step="5000" value="200000"
                        aria-label="{{ __('ui.simulator.amount') }}">
                    <div style="display:flex;justify-content:space-between;margin-top:8px;font-size:12px;color:rgba(255,255,255,0.3);">
                        <span>5 000 €</span>
                        <span>500 000 €</span>
                    </div>
                </div>

                {{-- Durée --}}
                <div class="sim-group">
                    <div class="sim-label">
                        <span>{{ __('ui.simulator.duration') }}</span>
                        <span id="sim-duration-val">20 {{ __('ui.simulator.years') }}</span>
                    </div>
                    <input type="range" class="sim-slider" id="sim-duration"
                        min="1" max="30" step="1" value="20"
                        aria-label="{{ __('ui.simulator.duration') }}">
                    <div style="display:flex;justify-content:space-between;margin-top:8px;font-size:12px;color:rgba(255,255,255,0.3);">
                        <span>1 {{ __('ui.simulator.years') }}</span>
                        <span>30 {{ __('ui.simulator.years') }}</span>
                    </div>
                </div>

                {{-- Apport --}}
                <div class="sim-group">
                    <div class="sim-label">
                        <span>{{ __('home.sim.down_payment') }}</span>
                        <span id="sim-apport-val">20 000 €</span>
                    </div>
                    <input type="range" class="sim-slider" id="sim-apport"
                        min="0" max="200000" step="1000" value="20000"
                        aria-label="{{ __('home.sim.down_payment') }}">
                    <div style="display:flex;justify-content:space-between;margin-top:8px;font-size:12px;color:rgba(255,255,255,0.3);">
                        <span>0 €</span>
                        <span>200 000 €</span>
                    </div>
                </div>
            </div>

            {{-- Résultats --}}
            <div class="simulator__results reveal stagger-2">
                <div class="sim-result-card sim-result-card--primary">
                    <p class="sim-result-label">{{ __('ui.simulator.monthly') }}</p>
                    <p class="sim-result-value" id="sim-monthly">850 €</p>
                    <p class="sim-result-sub">{{ __('home.sim.insurance') }}</p>
                </div>

                <div class="sim-results-row">
                    <div class="sim-result-card">
                        <p class="sim-result-label">{{ __('ui.simulator.total_cost') }}</p>
                        <p class="sim-result-value" style="font-size:24px;" id="sim-total">204 000 €</p>
                        <p class="sim-result-sub">{{ __('home.sim.interest_cap') }}</p>
                    </div>
                    <div class="sim-result-card">
                        <p class="sim-result-label">{{ __('home.sim.rate_applied') }}</p>
                        <p class="sim-result-value" style="font-size:24px;" id="sim-rate">1.9%</p>
                        <p class="sim-result-sub">{{ __('home.sim.taeg_indicative') }}</p>
                    </div>
                </div>

                <div class="sim-result-card">
                    <p class="sim-result-label">{{ __('home.sim.capital') }}</p>
                    <p class="sim-result-value" style="font-size:24px;" id="sim-capital">180 000 €</p>
                    <p class="sim-result-sub">{{ __('home.sim.amount_minus') }}</p>
                </div>

                <a href="/simulateur" class="btn btn-primary" style="width:100%;justify-content:center;">
                    {{ __('home.sim.full_cta') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     COMMENT ÇA MARCHE
═══════════════════════════════════════════════════════════ --}}
<section class="how">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('home.how.label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('home.how.title') }}</h2>
            <p class="section-desc reveal stagger-2">{{ __('home.how.desc') }}</p>
        </div>

        <div class="how__steps">
            @foreach([
                ['num'=>'01','icon'=>'🧮','title_key'=>'s1_title','desc_key'=>'s1_desc'],
                ['num'=>'02','icon'=>'📋','title_key'=>'s2_title','desc_key'=>'s2_desc'],
                ['num'=>'03','icon'=>'⚡','title_key'=>'s3_title','desc_key'=>'s3_desc'],
                ['num'=>'04','icon'=>'✅','title_key'=>'s4_title','desc_key'=>'s4_desc'],
            ] as $i => $step)
            <div class="how__step reveal stagger-{{ $i + 1 }}">
                <div class="how__step-num">{{ $step['num'] }}</div>
                <div class="how__step-icon">{{ $step['icon'] }}</div>
                <h4>{{ __('home.how.' . $step['title_key']) }}</h4>
                <p>{{ __('home.how.' . $step['desc_key']) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     CHIFFRES CLÉS
═══════════════════════════════════════════════════════════ --}}
<section class="stats">
    <div class="container">
        <div class="stats__grid">
            <div class="stat-item reveal">
                <div class="stat-item__value">
                    <span data-count="50" data-suffix="k+">0</span>
                </div>
                <p class="stat-item__label">{{ __('home.stats.stat1_label') }}</p>
                <p class="stat-item__sub">{{ __('home.stats.stat1_sub') }}</p>
            </div>
            <div class="stat-item reveal stagger-1">
                <div class="stat-item__value">
                    <span data-count="2.4" data-suffix="Md€" data-decimals="1">0</span>
                </div>
                <p class="stat-item__label">{{ __('home.stats.stat2_label') }}</p>
                <p class="stat-item__sub">{{ __('home.stats.stat2_sub') }}</p>
            </div>
            <div class="stat-item reveal stagger-2">
                <div class="stat-item__value">
                    <span data-count="98" data-suffix="%">0</span>
                </div>
                <p class="stat-item__label">{{ __('home.stats.stat3_label') }}</p>
                <p class="stat-item__sub">{{ __('home.stats.stat3_sub') }}</p>
            </div>
            <div class="stat-item reveal stagger-3">
                <div class="stat-item__value">
                    <span data-count="120" data-suffix="+">0</span>
                </div>
                <p class="stat-item__label">{{ __('home.stats.stat4_label') }}</p>
                <p class="stat-item__sub">{{ __('home.stats.stat4_sub') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     TÉMOIGNAGES
═══════════════════════════════════════════════════════════ --}}
<section class="testimonials">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('home.testimonials.label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('home.testimonials.title') }}</h2>
            <p class="section-desc reveal stagger-2">{{ __('home.testimonials.desc') }}</p>
        </div>

        <div class="testimonials__track-wrap reveal">
            <div class="testimonials__track" id="testimonials-track">

                @foreach($testimonials as $t)
                <div class="testimonial-card card">
                    <div class="testimonial-card__stars">{{ str_repeat('★', $t['stars']) }}</div>
                    <p class="testimonial-card__text">{{ $t['text'] }}</p>
                    <div class="testimonial-card__author">
                        <div class="testimonial-card__avatar">{{ substr($t['initials'], 0, 2) }}</div>
                        <div>
                            <p class="testimonial-card__name">{{ $t['name'] }}</p>
                            <p class="testimonial-card__role">{{ $t['role'] }} · {{ $t['city'] }}</p>
                            <span class="testimonial-card__loan">{{ $t['loan'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <div class="testimonials__controls">
                <button class="testimonials__arrow" id="prev-testimonial" aria-label="{{ __('home.testimonials.prev') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <div class="testimonials__dots" id="testimonials-dots"></div>
                <button class="testimonials__arrow" id="next-testimonial" aria-label="{{ __('home.testimonials.next') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>
        </div>

        <div style="text-align:center;margin-top:32px;">
            <a href="{{ route('testimonials') }}" class="btn btn-outline">
                {{ __('home.testimonials.see_all') }}
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     BLOG APERÇU
═══════════════════════════════════════════════════════════ --}}
<section class="blog-preview">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('home.blog.label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('home.blog.title') }}</h2>
            <p class="section-desc reveal stagger-2">{{ __('home.blog.desc') }}</p>
        </div>

        <div class="blog-preview__grid">

            {{-- Article featured --}}
            <a href="{{ route('blog.show', 'meilleur-taux-pret-immobilier-2025') }}" class="blog-card card reveal" style="text-decoration:none;color:inherit;display:block;">
                <div class="blog-card__img">
                    <span class="blog-card__img-placeholder">🏠</span>
                    <div class="blog-card__img-overlay"></div>
                </div>
                <div class="blog-card__body">
                    <span class="blog-card__tag">{{ __('home.blog.tag_immo') }}</span>
                    <h3 class="blog-card__title">{{ __('home.blog.art1_title') }}</h3>
                    <p class="blog-card__excerpt">{{ __('home.blog.art1_excerpt') }}</p>
                    <div class="blog-card__meta">
                        <span>{{ __('home.blog.art1_date') }}</span>
                        <span class="blog-card__meta-dot"></span>
                        <span>{{ __('home.blog.art1_read') }}</span>
                    </div>
                </div>
            </a>

            {{-- Articles secondaires --}}
            <div class="blog-preview__secondary">
                <a href="{{ route('blog.show', 'taux-endettement-guide-complet') }}" class="blog-card blog-card--sm card reveal stagger-1" style="text-decoration:none;color:inherit;display:block;">
                    <div class="blog-card__img">
                        <span class="blog-card__img-placeholder" style="font-size:36px;">📊</span>
                        <div class="blog-card__img-overlay"></div>
                    </div>
                    <div class="blog-card__body">
                        <span class="blog-card__tag">{{ __('home.blog.tag_finance') }}</span>
                        <h3 class="blog-card__title">{{ __('home.blog.art2_title') }}</h3>
                        <div class="blog-card__meta" style="margin-top:8px;">
                            <span>{{ __('home.blog.art2_date') }}</span>
                            <span class="blog-card__meta-dot"></span>
                            <span>{{ __('home.blog.art2_read') }}</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('blog.show', 'loa-vs-pret-auto') }}" class="blog-card blog-card--sm card reveal stagger-2" style="text-decoration:none;color:inherit;display:block;">
                    <div class="blog-card__img">
                        <span class="blog-card__img-placeholder" style="font-size:36px;">🚗</span>
                        <div class="blog-card__img-overlay"></div>
                    </div>
                    <div class="blog-card__body">
                        <span class="blog-card__tag">{{ __('home.blog.tag_auto') }}</span>
                        <h3 class="blog-card__title">{{ __('home.blog.art3_title') }}</h3>
                        <div class="blog-card__meta" style="margin-top:8px;">
                            <span>{{ __('home.blog.art3_date') }}</span>
                            <span class="blog-card__meta-dot"></span>
                            <span>{{ __('home.blog.art3_read') }}</span>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="blog-preview__cta reveal">
            <a href="/blog" class="btn btn-outline">{{ __('home.blog.see_all') }}</a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     CTA PLEINE LARGEUR
═══════════════════════════════════════════════════════════ --}}
<section class="cta-section">
    <div class="container">
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('home.cta.label') }}</span>
        <h2 class="section-title reveal stagger-1" style="margin-top:12px;">{{ __('home.cta.title') }}</h2>
        <p class="section-desc reveal stagger-2" style="max-width:600px;margin-inline:auto;">{{ __('home.cta.desc') }}</p>
        <div class="cta-section__actions reveal stagger-3">
            <a href="/simulateur" class="btn btn-primary" style="font-size:17px;padding:16px 36px;">
                {{ __('home.cta.sim') }}
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="/contact/rdv" class="btn" style="background:rgba(255,255,255,0.1);color:#fff;border:1px solid rgba(255,255,255,0.2);font-size:17px;padding:16px 36px;">
                {{ __('home.cta.rdv') }}
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     NEWSLETTER
═══════════════════════════════════════════════════════════ --}}
<section class="newsletter">
    <div class="container">
        <div class="newsletter__inner">
            <div class="newsletter__text reveal">
                <h3>{{ __('home.newsletter.title') }}</h3>
                <p>{{ __('home.newsletter.desc') }}</p>
            </div>
            <div class="reveal stagger-1" style="flex:1;">
                <form class="newsletter__form" data-source="home" novalidate>
                    @csrf
                    <input
                        type="email"
                        class="newsletter__input"
                        placeholder="{{ __('home.newsletter.placeholder') }}"
                        aria-label="{{ __('home.newsletter.placeholder') }}"
                        required>
                    <button type="submit" class="btn btn-primary">{{ __('home.newsletter.submit') }}</button>
                </form>
                <p class="newsletter__note">{{ __('home.newsletter.note') }} <a href="/confidentialite" style="color:var(--blue);">{{ __('home.newsletter.privacy') }}</a></p>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('js/home.js') }}"></script>
@endsection
