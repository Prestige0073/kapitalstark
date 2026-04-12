@extends('layouts.app')

@section('title', $loan['title'])
@section('description', $loan['desc'])

@section('styles')
<link rel="stylesheet" href="{{ asset('css/loan.css') }}">
@endsection

@section('content')

{{-- ── HERO ─────────────────────────────────────────────────── --}}
<section class="loan-hero" style="--loan-color:{{ $loan['color'] }}">
    <div class="loan-hero__bg"></div>
    <div class="container loan-hero__inner">
        <div class="loan-hero__content">
            <nav class="breadcrumb reveal" aria-label="breadcrumb">
                <a href="/">{{ __('loans.show.breadcrumb_home') }}</a>
                <span>›</span>
                <a href="/prets">{{ __('loans.show.breadcrumb_loans') }}</a>
                <span>›</span>
                <span>{{ $loan['title'] }}</span>
            </nav>

            <div class="loan-hero__icon reveal stagger-1">{{ $loan['icon'] }}</div>
            <h1 class="reveal stagger-1" style="color:#fff;">{{ $loan['title'] }}</h1>
            <p class="loan-hero__subtitle reveal stagger-2">{{ $loan['subtitle'] }}</p>
            <p class="loan-hero__desc reveal stagger-2">{{ $loan['desc'] }}</p>

            <div class="loan-hero__actions reveal stagger-3">
                <a href="/simulateur" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                    {{ __('loans.show.cta_sim') }}
                </a>
                <a href="/contact/rdv" class="btn" style="background:rgba(255,255,255,0.12);color:#fff;border:1px solid rgba(255,255,255,0.25);">
                    {{ __('loans.show.cta_advisor') }}
                </a>
            </div>
        </div>

        {{-- Carte conditions --}}
        <div class="loan-hero__card reveal stagger-2">
            <p class="loan-hero__card-label">{{ __('loans.show.card_label') }}</p>
            <div class="loan-hero__card-grid">
                <div class="loan-hero__card-item">
                    <span class="loan-hero__card-value font-mono">{{ $loan['rate_min'] }}%</span>
                    <span class="loan-hero__card-key">{{ __('loans.show.rate_min') }}</span>
                </div>
                <div class="loan-hero__card-item">
                    <span class="loan-hero__card-value font-mono">{{ $loan['rate_max'] }}%</span>
                    <span class="loan-hero__card-key">{{ __('loans.show.rate_max') }}</span>
                </div>
                <div class="loan-hero__card-item">
                    <span class="loan-hero__card-value">{{ $loan['amount_min'] }}</span>
                    <span class="loan-hero__card-key">{{ __('loans.show.amount_min') }}</span>
                </div>
                <div class="loan-hero__card-item">
                    <span class="loan-hero__card-value">{{ $loan['amount_max'] }}</span>
                    <span class="loan-hero__card-key">{{ __('loans.show.amount_max') }}</span>
                </div>
            </div>
            <div class="loan-hero__card-duration">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ __('loans.show.duration_up_to') }} <strong>{{ $loan['duration_max'] }}</strong>
            </div>
            <a href="/simulateur" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:20px;">
                {{ __('loans.show.calc_monthly') }}
            </a>
        </div>
    </div>
</section>

{{-- ── SOUS-CATÉGORIES ─────────────────────────────────────── --}}
<section style="background:var(--white);">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('loans.show.subcats_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('loans.show.subcats_title') }}</h2>
        </div>
        <div class="loan-subcats">
            @foreach($loan['subcategories'] as $i => $sub)
            <div class="loan-subcat card reveal stagger-{{ ($i % 4) + 1 }}">
                <div class="loan-subcat__icon">{{ $sub['icon'] }}</div>
                <h3 class="loan-subcat__title">{{ $sub['title'] }}</h3>
                <p class="loan-subcat__desc">{{ $sub['desc'] }}</p>
                <a href="/simulateur" class="btn-ghost" style="font-size:14px;font-weight:600;color:var(--blue);display:inline-flex;align-items:center;gap:4px;margin-top:16px;padding:0;">
                    {{ __('loans.show.simulate_arrow') }}
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── TABLEAU CONDITIONS ──────────────────────────────────── --}}
<section style="background:var(--cream);">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('loans.show.table_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('loans.show.table_title') }}</h2>
            <p class="section-desc reveal stagger-2">{{ __('loans.show.table_desc') }}</p>
        </div>
        <div class="loan-table-wrap reveal">
            <table class="loan-table">
                <thead>
                    <tr>
                        <th>{{ __('loans.show.th_duration') }}</th>
                        <th>{{ __('loans.show.th_rate_min') }}</th>
                        <th>{{ __('loans.show.th_rate_max') }}</th>
                        <th>{{ __('loans.show.th_monthly') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $rows = [];
                    $rMin = (float)$loan['rate_min'] / 100;
                    $rMax = (float)$loan['rate_max'] / 100;
                    $dMax = (int)filter_var($loan['duration_max'], FILTER_SANITIZE_NUMBER_INT);
                    $steps = $dMax > 10 ? [5,10,15,20,25,30] : [1,2,3,4,5,6,7];
                    foreach($steps as $y) {
                        if ($y > $dMax) break;
                        $m = $y * 12;
                        $r = $rMin / 12;
                        $monthly = $r > 0 ? 10000 * $r * pow(1+$r,$m) / (pow(1+$r,$m)-1) : 10000/$m;
                        $rows[] = ['dur'=>$y.' '.__('ui.simulator.years'), 'rMin'=>number_format($rMin*100,1).'%', 'rMax'=>number_format($rMax*100,1).'%', 'monthly'=>number_format($monthly,0,',',' ').' €'];
                    }
                    @endphp
                    @foreach($rows as $row)
                    <tr>
                        <td><strong>{{ $row['dur'] }}</strong></td>
                        <td class="font-mono" style="color:var(--blue);">{{ $row['rMin'] }}</td>
                        <td class="font-mono">{{ $row['rMax'] }}</td>
                        <td class="font-mono"><strong>{{ $row['monthly'] }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="font-size:12px;color:var(--text-muted);margin-top:12px;">
                {{ __('loans.show.table_note') }}
            </p>
        </div>
    </div>
</section>

{{-- ── ÉTAPES ──────────────────────────────────────────────── --}}
<section style="background:var(--white);">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('home.how.label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('loans.show.how_title') }}</h2>
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
                <h4>{{ __('loans.show.' . $step['title_key']) }}</h4>
                <p>{{ __('loans.show.' . $step['desc_key']) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── DOCUMENTS REQUIS ────────────────────────────────────── --}}
<section style="background:var(--cream);">
    <div class="container">
        <div class="loan-docs__inner">
            <div class="reveal">
                <span class="section-label">{{ __('loans.show.docs_label') }}</span>
                <h2 class="section-title" style="margin-top:12px;">{{ __('loans.show.docs_title') }}</h2>
                <p class="section-desc" style="text-align:left;margin-top:12px;">{{ __('loans.show.docs_desc') }}</p>
            </div>
            <ul class="loan-docs__list">
                @foreach($loan['documents'] as $i => $doc)
                <li class="loan-docs__item reveal stagger-{{ ($i % 5) + 1 }}">
                    <span class="loan-docs__check">✓</span>
                    {{ $doc }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

{{-- ── FAQ ──────────────────────────────────────────────────── --}}
<section style="background:var(--white);">
    <div class="container loan-faq">
        <div class="section-header">
            <span class="section-label reveal">{{ __('loans.show.faq_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('loans.show.faq_title') }}</h2>
        </div>
        <div class="faq-list">
            @foreach($loan['faq'] as $i => $item)
            <div class="faq-item reveal stagger-{{ $i + 1 }}">
                <button class="faq-item__q" aria-expanded="false">
                    {{ $item['q'] }}
                    <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </button>
                <div class="faq-item__a">
                    <p>{{ $item['r'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── AUTRES PRÊTS ────────────────────────────────────────── --}}
<section style="background:var(--cream);">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('loans.show.others_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('loans.show.others_title') }}</h2>
        </div>
        <div class="loan-others">
            @foreach($loans as $key => $other)
                @if($key !== $loan['type'])
                <a href="/prets/{{ $key }}" class="loan-other-card card reveal">
                    <span class="loan-other-card__icon">{{ $other['icon'] }}</span>
                    <strong>{{ $other['title'] }}</strong>
                    <span class="font-mono" style="font-size:13px;color:var(--blue);">{{ __('loans.show.others_from') }} {{ $other['rate_min'] }}%</span>
                </a>
                @endif
            @endforeach
        </div>
    </div>
</section>

{{-- ── CTA ──────────────────────────────────────────────────── --}}
<section class="cta-section">
    <div class="container">
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ $loan['title'] }}</span>
        <h2 class="section-title reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('loans.show.cta_title') }}</h2>
        <p class="section-desc reveal stagger-2" style="color:rgba(255,255,255,0.65);max-width:560px;margin-inline:auto;">
            {{ __('loans.show.cta_desc') }}
        </p>
        <div class="cta-section__actions reveal stagger-3">
            <a href="/simulateur" class="btn btn-primary" style="font-size:17px;padding:16px 36px;">{{ __('loans.show.cta_sim') }}</a>
            <a href="/contact" class="btn" style="background:rgba(255,255,255,0.1);color:#fff;border:1px solid rgba(255,255,255,0.2);font-size:17px;padding:16px 36px;">{{ __('loans.show.cta_contact') }}</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.faq-item__q').forEach(btn => {
  btn.addEventListener('click', () => {
    const item = btn.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
    document.querySelectorAll('.faq-item__q').forEach(b => b.setAttribute('aria-expanded','false'));
    if (!isOpen) {
      item.classList.add('open');
      btn.setAttribute('aria-expanded','true');
    }
  });
});
</script>
@endsection
