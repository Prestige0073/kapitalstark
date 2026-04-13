@extends('layouts.app')
@section('title', __('pages.titles.guides'))
@section('description', __('pages.guides.hero_sub'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:80px 60px;">
    <div class="container page-hero__inner">
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.guides.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('pages.guides.hero_title') }}</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;max-width:600px;margin-inline:auto;margin-top:12px;">
            {{ __('pages.guides.hero_sub') }}
        </p>
    </div>
</section>

<section style="background:var(--white);">
    <div class="container">

        {{-- Guide vedette --}}
        <div class="reveal" style="margin-bottom:60px;">
            <div class="card g-2-split" style="border-radius:24px;">
                <div style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding:48px;display:flex;flex-direction:column;justify-content:space-between;">
                    <div>
                        <span class="section-label" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.guides.featured_label') }}</span>
                        <h2 style="color:#fff;font-size:28px;margin-top:14px;margin-bottom:16px;">{{ __('pages.guides.featured_title') }}</h2>
                        <p style="color:rgba(255,255,255,0.65);font-size:15px;line-height:1.7;">{{ __('pages.guides.featured_desc') }}</p>
                        <svg viewBox="0 0 200 100" xmlns="http://www.w3.org/2000/svg" style="width:220px;height:110px;opacity:0.9;margin:20px auto 0;display:block;" aria-hidden="true">
                            <line x1="10" y1="20" x2="190" y2="20" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                            <line x1="10" y1="50" x2="190" y2="50" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                            <line x1="10" y1="80" x2="190" y2="80" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                            <path d="M10,80 L45,62 L80,68 L115,38 L150,44 L185,18 L190,20 L190,90 L10,90 Z" fill="rgba(255,255,255,0.1)"/>
                            <polyline points="10,80 45,62 80,68 115,38 150,44 185,18"
                                fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="185" cy="18" r="5" fill="white" class="guide-svg-pulse"/>
                            <text x="2" y="22" font-size="8" fill="rgba(255,255,255,0.5)" font-family="monospace">+12%</text>
                            <text x="2" y="82" font-size="8" fill="rgba(255,255,255,0.5)" font-family="monospace">0%</text>
                            <rect x="140" y="4" width="52" height="20" rx="5" fill="rgba(34,197,94,0.25)" stroke="rgba(34,197,94,0.5)" stroke-width="1"/>
                            <text x="166" y="18" text-anchor="middle" font-size="10" font-weight="700" fill="#86efac" font-family="monospace">+12%</text>
                        </svg>
                    </div>
                    <div style="margin-top:28px;display:flex;gap:16px;flex-wrap:wrap;">
                        <div style="font-size:13px;color:rgba(255,255,255,0.5);display:flex;align-items:center;gap:6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ __('pages.guides.featured_read') }}
                        </div>
                        <div style="font-size:13px;color:rgba(255,255,255,0.5);display:flex;align-items:center;gap:6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            {{ __('pages.guides.featured_steps') }}
                        </div>
                        <div style="font-size:13px;color:rgba(255,255,255,0.5);display:flex;align-items:center;gap:6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ __('pages.guides.featured_updated') }}
                        </div>
                    </div>
                </div>
                <div style="padding:48px;display:flex;flex-direction:column;gap:14px;">
                    <h3 style="font-size:16px;margin-bottom:8px;">{{ __('pages.guides.featured_learn') }}</h3>
                    @foreach(trans('pages.guides.featured_steps_list') as $step)
                    <div style="display:flex;align-items:flex-start;gap:10px;font-size:14px;color:var(--text-muted);">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.5" style="flex-shrink:0;margin-top:2px;"><path d="M20 6L9 17l-5-5"/></svg>
                        {{ $step }}
                    </div>
                    @endforeach
                    <a href="{{ route('simulator.index') }}" class="btn btn-primary" style="margin-top:8px;justify-content:center;">
                        {{ __('pages.guides.cta_sim') }} →
                    </a>
                </div>
            </div>
        </div>

        {{-- Grille des guides --}}
        @php
        $guides = trans('pages.guides.items');
        $cats   = array_values(array_unique(array_column($guides, 'cat')));
        @endphp

        {{-- Filtres --}}
        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:32px;" class="reveal" id="guide-filters">
            <button class="faq-cat active" data-cat="all">{{ __('pages.guides.filter_all') }}</button>
            @foreach($cats as $cat)
            <button class="faq-cat" data-cat="{{ $cat }}">{{ $cat }}</button>
            @endforeach
        </div>

        <div class="g-3" style="gap:24px;" id="guides-grid">
            @foreach($guides as $i => $guide)
            <div class="card guide-card reveal stagger-{{ ($i % 3) + 1 }}" data-cat="{{ $guide['cat'] }}">
                <div class="guide-card__visual">
                    @php $animIdx = $i % 4; @endphp
                    @if($animIdx === 0)
                    {{-- Courbe de tendance --}}
                    <svg viewBox="0 0 120 80" xmlns="http://www.w3.org/2000/svg" style="width:120px;height:80px;" aria-hidden="true">
                        <line x1="10" y1="15" x2="110" y2="15" stroke="#267BF1" stroke-width="0.8" opacity="0.25"/>
                        <line x1="10" y1="40" x2="110" y2="40" stroke="#267BF1" stroke-width="0.8" opacity="0.25"/>
                        <line x1="10" y1="65" x2="110" y2="65" stroke="#267BF1" stroke-width="0.8" opacity="0.25"/>
                        <path d="M10,65 L30,50 L50,54 L70,30 L90,35 L110,12 L110,72 L10,72 Z" fill="#267BF1" opacity="0.12"/>
                        <polyline points="10,65 30,50 50,54 70,30 90,35 110,12"
                            fill="none" stroke="#267BF1" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="110" cy="12" r="4.5" fill="#267BF1" class="guide-svg-pulse"/>
                    </svg>
                    @elseif($animIdx === 1)
                    {{-- Barres --}}
                    <svg viewBox="0 0 110 80" xmlns="http://www.w3.org/2000/svg" style="width:110px;height:80px;" aria-hidden="true">
                        <line x1="8" y1="72" x2="102" y2="72" stroke="#267BF1" stroke-width="1" opacity="0.25"/>
                        <rect x="12" y="44" width="16" height="28" rx="4" fill="#267BF1" opacity="0.35"/>
                        <rect x="36" y="28" width="16" height="44" rx="4" fill="#267BF1" opacity="0.55"/>
                        <rect x="60" y="36" width="16" height="36" rx="4" fill="#267BF1" opacity="0.75"/>
                        <rect x="84" y="14" width="16" height="58" rx="4" fill="#267BF1"/>
                        <polyline points="20,44 44,28 68,36 92,14"
                            fill="none" stroke="#267BF1" stroke-width="1.5" stroke-dasharray="4 3" opacity="0.5" stroke-linecap="round"/>
                    </svg>
                    @elseif($animIdx === 2)
                    {{-- Pile de pièces --}}
                    <svg viewBox="0 0 110 80" xmlns="http://www.w3.org/2000/svg" style="width:110px;height:80px;" aria-hidden="true">
                        <ellipse cx="55" cy="70" rx="30" ry="8" fill="#267BF1" opacity="0.2"/>
                        <ellipse cx="55" cy="62" rx="30" ry="8" fill="#267BF1" opacity="0.35"/>
                        <ellipse cx="55" cy="54" rx="30" ry="8" fill="#267BF1" opacity="0.5"/>
                        <ellipse cx="55" cy="46" rx="30" ry="8" fill="#267BF1" opacity="0.7"/>
                        <ellipse cx="55" cy="38" rx="30" ry="8" fill="#267BF1" opacity="0.9"/>
                        <text x="45" y="43" font-size="12" font-weight="700" fill="white" font-family="monospace">€</text>
                        <text x="34" y="20" font-size="11" font-weight="700" fill="#267BF1" font-family="monospace">+2 400€</text>
                    </svg>
                    @else
                    {{-- Anneau de progression --}}
                    <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" style="width:80px;height:80px;" aria-hidden="true">
                        <circle cx="40" cy="40" r="30" fill="none" stroke="#267BF1" stroke-width="8" opacity="0.15"/>
                        <circle cx="40" cy="40" r="30" fill="none" stroke="#267BF1" stroke-width="8"
                            stroke-dasharray="188" stroke-dashoffset="47" stroke-linecap="round"
                            transform="rotate(-90 40 40)"/>
                        <text x="40" y="45" text-anchor="middle" font-size="14" font-weight="700" fill="#267BF1" font-family="monospace">75%</text>
                    </svg>
                    @endif
                </div>
                <div style="padding:28px 28px 0;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                        <div style="width:44px;height:44px;border-radius:12px;background:rgba(38,123,241,0.08);display:flex;align-items:center;justify-content:center;font-size:22px;">
                            {{ $guide['icon'] }}
                        </div>
                        <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:{{ $guide['color'] }};background:rgba(38,123,241,0.07);padding:4px 10px;border-radius:100px;">
                            {{ $guide['cat'] }}
                        </span>
                    </div>
                    <h3 style="font-size:17px;margin-bottom:10px;line-height:1.4;">{{ $guide['title'] }}</h3>
                    <p style="font-size:14px;color:var(--text-muted);line-height:1.65;margin-bottom:20px;">{{ $guide['desc'] }}</p>
                </div>
                <div style="padding:0 28px 20px;border-top:1px solid rgba(38,123,241,0.07);margin-top:auto;padding-top:16px;">
                    <div style="display:flex;gap:16px;font-size:12px;color:var(--text-muted);margin-bottom:16px;">
                        <span style="display:flex;align-items:center;gap:4px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $guide['read'] }}
                        </span>
                        <span style="display:flex;align-items:center;gap:4px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            {{ $guide['steps'] }} {{ __('pages.guides.steps_label') }}
                        </span>
                        <span style="display:flex;align-items:center;gap:4px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ $guide['updated'] }}
                        </span>
                    </div>
                    <a href="{{ route('blog.show', $guide['slug']) }}" class="btn btn-outline" style="width:100%;justify-content:center;font-size:13px;padding:10px;">
                        {{ __('pages.guides.read_guide') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- CTA --}}
<section class="cta-section" style="padding-block:80px;">
    <div class="container">
        <h2 class="section-title reveal" style="color:#fff;">{{ __('pages.guides.cta_title') }}</h2>
        <p class="section-desc reveal stagger-1" style="color:rgba(255,255,255,0.65);max-width:520px;margin-inline:auto;">
            {{ __('pages.guides.cta_sub') }}
        </p>
        <div class="cta-section__actions reveal stagger-2">
            <a href="{{ route('simulator.index') }}" class="btn btn-primary" style="font-size:17px;padding:16px 36px;">{{ __('pages.guides.cta_sim') }}</a>
            <a href="{{ route('contact.rdv') }}" class="btn" style="background:rgba(255,255,255,0.1);color:#fff;border:1px solid rgba(255,255,255,0.2);font-size:17px;padding:16px 36px;">{{ __('pages.guides.cta_rdv') }}</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
(function () {
    'use strict';
    var btns  = document.querySelectorAll('#guide-filters .faq-cat');
    var cards = document.querySelectorAll('#guides-grid .guide-card');

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
})();
</script>
@endsection
