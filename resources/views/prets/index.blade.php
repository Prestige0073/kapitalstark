@extends('layouts.app')
@section('title', __('loans.index.meta_title'))
@section('description', __('loans.index.meta_desc'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

{{-- Hero --}}
<section class="page-hero loans-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:80px 60px;">
    <div class="container page-hero__inner">
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('loans.index.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('loans.index.hero_title') }}</h1>
        <p class="reveal stagger-2 loans-hero__sub">{{ __('loans.index.hero_sub') }}</p>

        {{-- Barre de recherche rapide --}}
        <div class="reveal stagger-3 loans-hero__search">
            <input type="text" id="loan-search" placeholder="{{ __('loans.index.search_ph') }}"
                   style="width:100%;padding:16px 56px 16px 20px;border-radius:100px;border:none;font-size:15px;font-family:var(--font-sans);color:var(--text);outline:none;box-shadow:0 4px 24px rgba(0,0,0,0.15);">
            <svg style="position:absolute;right:20px;top:50%;transform:translateY(-50%);color:var(--text-muted);" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>

        {{-- Stats rapides --}}
        <div class="reveal stagger-4 loans-hero__stats">
            @foreach([
                __('loans.index.stat1'),
                __('loans.index.stat2'),
                __('loans.index.stat3'),
                __('loans.index.stat4'),
            ] as $s)
            <div style="display:flex;align-items:center;gap:8px;font-size:14px;color:rgba(255,255,255,0.7);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5" style="flex-shrink:0;"><path d="M20 6L9 17l-5-5"/></svg>
                {{ $s }}
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Grille des prêts --}}
<section style="background:var(--cream);">
    <div class="container">

        {{-- Filtres --}}
        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:32px;" class="reveal" id="loan-filters">
            <button class="faq-cat active" data-cat="all">{{ __('loans.index.filter_all') }}</button>
            <button class="faq-cat" data-cat="particuliers">{{ __('loans.index.filter_indiv') }}</button>
            <button class="faq-cat" data-cat="professionnels">{{ __('loans.index.filter_pro') }}</button>
        </div>

        <div id="loans-grid" class="g-3" style="gap:24px;">
            @php
            $loanMeta = [
                'immobilier'  => ['cat'=>'particuliers','highlight'=>true, 'badge_key'=>'badge_popular'],
                'automobile'  => ['cat'=>'particuliers','highlight'=>false,'badge_key'=>null],
                'personnel'   => ['cat'=>'particuliers','highlight'=>false,'badge_key'=>null],
                'entreprise'  => ['cat'=>'professionnels','highlight'=>false,'badge_key'=>'badge_1m'],
                'agricole'    => ['cat'=>'professionnels','highlight'=>false,'badge_key'=>'badge_season'],
                'microcredit' => ['cat'=>'particuliers','highlight'=>false,'badge_key'=>'badge_micro'],
            ];
            @endphp

            @foreach($loans as $key => $loan)
            @php $meta = $loanMeta[$key] ?? ['cat'=>'particuliers','highlight'=>false,'badge_key'=>null]; @endphp
            <div class="card loan-overview-card reveal stagger-{{ ($loop->index % 3) + 1 }}"
                 data-cat="{{ $meta['cat'] }}"
                 style="{{ $meta['highlight'] ? 'border:2px solid var(--blue);' : '' }}">
                @if($meta['badge_key'])
                <div style="position:absolute;top:-1px;right:20px;background:{{ $meta['highlight'] ? 'var(--blue)' : 'var(--gold)' }};color:#fff;font-size:11px;font-weight:700;padding:4px 12px;border-radius:0 0 10px 10px;letter-spacing:0.04em;text-transform:uppercase;">
                    {{ __('loans.index.' . $meta['badge_key']) }}
                </div>
                @endif
                <div style="padding:32px 28px 0;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                        <div style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,var(--navy),var(--blue-dark));display:flex;align-items:center;justify-content:center;font-size:26px;">
                            {{ $loan['icon'] }}
                        </div>
                        <span class="font-mono" style="font-size:28px;font-weight:700;color:var(--blue);">{{ $loan['rate_min'] }}<span style="font-size:16px;color:var(--text-muted);">%</span></span>
                    </div>
                    <h2 style="font-size:20px;margin-bottom:8px;">{{ $loan['title'] }}</h2>
                    <p style="font-size:14px;color:var(--text-muted);line-height:1.65;margin-bottom:20px;">{{ $loan['desc'] }}</p>

                    <div class="loan-index-detail-grid">
                        @foreach([
                            ['key'=> __('loans.index.detail_amount'), 'val'=> $loan['amount_min'].' → '.$loan['amount_max']],
                            ['key'=> __('loans.index.detail_dur'),    'val'=> $loan['duration_max']],
                            ['key'=> __('loans.index.detail_rate'),   'val'=> $loan['rate_min'].'% → '.$loan['rate_max'].'%'],
                            ['key'=> __('loans.index.detail_cats'),   'val'=> count($loan['subcategories']).' '.__('loans.index.solutions')],
                        ] as $detail)
                        <div style="background:rgba(38,123,241,0.04);border-radius:10px;padding:10px 12px;">
                            <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--text-muted);margin-bottom:3px;">{{ $detail['key'] }}</p>
                            <p style="font-size:13px;font-weight:600;color:var(--text);font-family:var(--font-mono);">{{ $detail['val'] }}</p>
                        </div>
                        @endforeach
                    </div>

                    {{-- Sous-catégories --}}
                    <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:24px;">
                        @foreach($loan['subcategories'] as $sub)
                        <span style="font-size:11px;padding:4px 10px;border-radius:100px;background:rgba(38,123,241,0.07);color:var(--blue);font-weight:600;">
                            {{ $sub['icon'] }} {{ $sub['title'] }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <div style="padding:0 28px 24px;border-top:1px solid rgba(38,123,241,0.07);padding-top:16px;display:flex;gap:8px;">
                    <a href="/prets/{{ $key }}" class="btn {{ $meta['highlight'] ? 'btn-primary' : 'btn-outline' }}" style="flex:1;justify-content:center;font-size:13px;padding:10px;">
                        {{ __('loans.index.learn_more') }}
                    </a>
                    <a href="{{ route('simulator.index') }}" class="btn btn-ghost" style="font-size:13px;padding:10px 14px;border:1px solid rgba(38,123,241,0.15);" title="{{ __('loans.index.simulate') }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- Comparatif rapide --}}
<section style="background:var(--white);">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('loans.index.comp_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('loans.index.comp_title') }}</h2>
            <p class="section-desc reveal stagger-2">{{ __('loans.index.comp_desc') }}</p>
        </div>

        <div class="reveal" style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:14px;min-width:700px;">
                <thead>
                    <tr style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));">
                        <th style="padding:16px 20px;text-align:left;color:rgba(255,255,255,0.7);font-size:12px;text-transform:uppercase;letter-spacing:0.07em;font-weight:700;">{{ __('loans.index.th_type') }}</th>
                        <th style="padding:16px 20px;text-align:center;color:rgba(255,255,255,0.7);font-size:12px;text-transform:uppercase;letter-spacing:0.07em;font-weight:700;">{{ __('loans.index.th_rate_min') }}</th>
                        <th style="padding:16px 20px;text-align:center;color:rgba(255,255,255,0.7);font-size:12px;text-transform:uppercase;letter-spacing:0.07em;font-weight:700;">{{ __('loans.index.th_amount_max') }}</th>
                        <th style="padding:16px 20px;text-align:center;color:rgba(255,255,255,0.7);font-size:12px;text-transform:uppercase;letter-spacing:0.07em;font-weight:700;">{{ __('loans.index.th_dur_max') }}</th>
                        <th style="padding:16px 20px;text-align:center;color:rgba(255,255,255,0.7);font-size:12px;text-transform:uppercase;letter-spacing:0.07em;font-weight:700;">{{ __('loans.index.th_response') }}</th>
                        <th style="padding:16px 20px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loans as $key => $loan)
                    <tr style="border-bottom:1px solid rgba(38,123,241,0.07);transition:background 0.15s;" onmouseenter="this.style.background='rgba(38,123,241,0.03)'" onmouseleave="this.style.background=''">
                        <td style="padding:16px 20px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <span style="font-size:22px;">{{ $loan['icon'] }}</span>
                                <strong style="font-size:15px;color:var(--text);">{{ $loan['title'] }}</strong>
                            </div>
                        </td>
                        <td style="padding:16px 20px;text-align:center;">
                            <span class="font-mono" style="font-size:16px;font-weight:700;color:var(--blue);">{{ $loan['rate_min'] }}%</span>
                        </td>
                        <td style="padding:16px 20px;text-align:center;color:var(--text-muted);font-family:var(--font-mono);">{{ $loan['amount_max'] }}</td>
                        <td style="padding:16px 20px;text-align:center;color:var(--text-muted);">{{ $loan['duration_max'] }}</td>
                        <td style="padding:16px 20px;text-align:center;">
                            <span style="font-size:12px;font-weight:700;color:#15803d;background:rgba(34,197,94,0.1);padding:4px 10px;border-radius:100px;">24h</span>
                        </td>
                        <td style="padding:16px 20px;text-align:right;">
                            <a href="/prets/{{ $key }}" style="font-size:13px;font-weight:600;color:var(--blue);white-space:nowrap;">
                                {{ __('loans.index.see') }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p style="font-size:12px;color:var(--text-muted);margin-top:12px;text-align:right;">
            {{ __('loans.index.rate_note') }} <a href="{{ route('simulator.index') }}" style="color:var(--blue);font-weight:600;">{{ __('loans.index.sim_link') }}</a>
        </p>
    </div>
</section>

{{-- Processus --}}
<section style="background:var(--cream);">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('loans.index.how_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('loans.how.title') }}</h2>
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
                <h4>{{ __('loans.how.' . $step['title_key']) }}</h4>
                <p>{{ __('loans.how.' . $step['desc_key']) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Pourquoi KapitalStark --}}
<section style="background:var(--white);">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('loans.index.why_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('loans.index.why_title') }}</h2>
        </div>
        <div class="g-3" style="gap:24px;">
            @foreach([
                ['icon'=>'🔍','title_key'=>'why1_title','desc_key'=>'why1_desc'],
                ['icon'=>'⚡','title_key'=>'why2_title','desc_key'=>'why2_desc'],
                ['icon'=>'🎯','title_key'=>'why3_title','desc_key'=>'why3_desc'],
                ['icon'=>'🔒','title_key'=>'why4_title','desc_key'=>'why4_desc'],
                ['icon'=>'💡','title_key'=>'why5_title','desc_key'=>'why5_desc'],
                ['icon'=>'🏆','title_key'=>'why6_title','desc_key'=>'why6_desc'],
            ] as $i => $why)
            <div class="card reveal stagger-{{ ($i % 3) + 1 }}" style="padding:28px;">
                <div style="font-size:32px;margin-bottom:14px;">{{ $why['icon'] }}</div>
                <h3 style="font-size:17px;margin-bottom:10px;">{{ __('loans.index.' . $why['title_key']) }}</h3>
                <p style="font-size:14px;color:var(--text-muted);line-height:1.65;">{{ __('loans.index.' . $why['desc_key']) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section" style="padding-block:80px;">
    <div class="container">
        <h2 class="section-title reveal" style="color:#fff;">{{ __('loans.index.cta_title') }}</h2>
        <p class="section-desc reveal stagger-1" style="color:rgba(255,255,255,0.65);max-width:520px;margin-inline:auto;">
            {{ __('loans.index.cta_desc') }}
        </p>
        <div class="cta-section__actions reveal stagger-2">
            <a href="{{ route('simulator.index') }}" class="btn btn-primary" style="font-size:17px;padding:16px 36px;">{{ __('loans.index.cta_sim') }}</a>
            <a href="{{ route('contact.rdv') }}" class="btn" style="background:rgba(255,255,255,0.1);color:#fff;border:1px solid rgba(255,255,255,0.2);font-size:17px;padding:16px 36px;">{{ __('loans.index.cta_rdv') }}</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<style>
.loan-overview-card { position: relative; overflow: visible !important; }
</style>
<script>
(function () {
    'use strict';

    var btns  = document.querySelectorAll('#loan-filters .faq-cat');
    var cards = document.querySelectorAll('#loans-grid .loan-overview-card');

    btns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            btns.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var cat = btn.getAttribute('data-cat');
            cards.forEach(function (card) {
                card.style.display = (cat === 'all' || card.getAttribute('data-cat') === cat) ? '' : 'none';
            });
        });
    });

    var search = document.getElementById('loan-search');
    if (search) {
        search.addEventListener('input', function () {
            var q = this.value.toLowerCase().trim();
            cards.forEach(function (card) {
                var text = card.textContent.toLowerCase();
                card.style.display = (!q || text.indexOf(q) !== -1) ? '' : 'none';
            });
            if (q) {
                btns.forEach(function (b) { b.classList.remove('active'); });
                btns[0].classList.add('active');
            }
        });
    }
})();
</script>
@endsection
