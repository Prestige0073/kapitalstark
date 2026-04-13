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
                        <svg viewBox="0 0 200 100" xmlns="http://www.w3.org/2000/svg" style="width:220px;height:110px;opacity:0.85;margin:20px auto 0;display:block;" aria-hidden="true">
                            <line x1="10" y1="20" x2="190" y2="20" stroke="rgba(255,255,255,0.12)" stroke-width="1"/>
                            <line x1="10" y1="50" x2="190" y2="50" stroke="rgba(255,255,255,0.12)" stroke-width="1"/>
                            <line x1="10" y1="80" x2="190" y2="80" stroke="rgba(255,255,255,0.12)" stroke-width="1"/>
                            <path d="M10,80 L45,62 L80,68 L115,38 L150,44 L185,18 L190,20 L190,90 L10,90 Z" fill="rgba(255,255,255,0.06)"/>
                            <polyline points="10,80 45,62 80,68 115,38 150,44 185,18"
                                fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                stroke-dasharray="400" stroke-dashoffset="400">
                                <animate attributeName="stroke-dashoffset" from="400" to="0" dur="2s" begin="0.3s" fill="freeze"/>
                            </polyline>
                            <circle cx="185" cy="18" r="4" fill="white" opacity="0">
                                <animate attributeName="opacity" from="0" to="1" dur="0.3s" begin="2.2s" fill="freeze"/>
                                <animate attributeName="r" values="4;6;4" dur="2s" begin="2.5s" repeatCount="indefinite"/>
                            </circle>
                            <text x="2" y="22" font-size="8" fill="rgba(255,255,255,0.4)" font-family="monospace">+12%</text>
                            <text x="2" y="82" font-size="8" fill="rgba(255,255,255,0.4)" font-family="monospace">0%</text>
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
                    <svg viewBox="0 0 100 70" xmlns="http://www.w3.org/2000/svg" style="width:100px;height:70px;" aria-hidden="true">
                        <line x1="8" y1="15" x2="92" y2="15" stroke="#267BF1" stroke-width="0.5" opacity="0.2"/>
                        <line x1="8" y1="35" x2="92" y2="35" stroke="#267BF1" stroke-width="0.5" opacity="0.2"/>
                        <line x1="8" y1="55" x2="92" y2="55" stroke="#267BF1" stroke-width="0.5" opacity="0.2"/>
                        <path d="M8,55 L25,42 L42,46 L58,28 L75,32 L92,12 L92,65 L8,65 Z" fill="#267BF1" opacity="0.07"/>
                        <polyline points="8,55 25,42 42,46 58,28 75,32 92,12"
                            fill="none" stroke="#267BF1" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                            stroke-dasharray="200" stroke-dashoffset="200">
                            <animate attributeName="stroke-dashoffset" from="200" to="0" dur="1.5s" begin="0.3s" fill="freeze"/>
                        </polyline>
                        <circle cx="92" cy="12" r="3.5" fill="#267BF1" opacity="0">
                            <animate attributeName="opacity" from="0" to="1" dur="0.2s" begin="1.7s" fill="freeze"/>
                            <animate attributeName="r" values="3.5;5;3.5" dur="2s" begin="1.9s" repeatCount="indefinite"/>
                        </circle>
                    </svg>
                    @elseif($animIdx === 1)
                    {{-- Barres croissantes --}}
                    <svg viewBox="0 0 100 70" xmlns="http://www.w3.org/2000/svg" style="width:100px;height:70px;" aria-hidden="true">
                        <line x1="5" y1="65" x2="95" y2="65" stroke="#267BF1" stroke-width="1" opacity="0.2"/>
                        <rect x="10" y="65" width="14" height="0" rx="3" fill="#267BF1" opacity="0.35">
                            <animate attributeName="height" from="0" to="28" dur="0.6s" begin="0.2s" fill="freeze" calcMode="spline" keySplines="0.4 0 0.2 1"/>
                            <animate attributeName="y" from="65" to="37" dur="0.6s" begin="0.2s" fill="freeze" calcMode="spline" keySplines="0.4 0 0.2 1"/>
                        </rect>
                        <rect x="32" y="65" width="14" height="0" rx="3" fill="#267BF1" opacity="0.55">
                            <animate attributeName="height" from="0" to="40" dur="0.6s" begin="0.4s" fill="freeze" calcMode="spline" keySplines="0.4 0 0.2 1"/>
                            <animate attributeName="y" from="65" to="25" dur="0.6s" begin="0.4s" fill="freeze" calcMode="spline" keySplines="0.4 0 0.2 1"/>
                        </rect>
                        <rect x="54" y="65" width="14" height="0" rx="3" fill="#267BF1" opacity="0.75">
                            <animate attributeName="height" from="0" to="33" dur="0.6s" begin="0.6s" fill="freeze" calcMode="spline" keySplines="0.4 0 0.2 1"/>
                            <animate attributeName="y" from="65" to="32" dur="0.6s" begin="0.6s" fill="freeze" calcMode="spline" keySplines="0.4 0 0.2 1"/>
                        </rect>
                        <rect x="76" y="65" width="14" height="0" rx="3" fill="#267BF1">
                            <animate attributeName="height" from="0" to="50" dur="0.6s" begin="0.8s" fill="freeze" calcMode="spline" keySplines="0.4 0 0.2 1"/>
                            <animate attributeName="y" from="65" to="15" dur="0.6s" begin="0.8s" fill="freeze" calcMode="spline" keySplines="0.4 0 0.2 1"/>
                        </rect>
                    </svg>
                    @elseif($animIdx === 2)
                    {{-- Pile de pièces --}}
                    <svg viewBox="0 0 100 70" xmlns="http://www.w3.org/2000/svg" style="width:100px;height:70px;" aria-hidden="true">
                        <ellipse cx="50" cy="62" rx="26" ry="7" fill="#267BF1" opacity="0">
                            <animate attributeName="opacity" from="0" to="0.2" dur="0.35s" begin="0.1s" fill="freeze"/>
                        </ellipse>
                        <ellipse cx="50" cy="54" rx="26" ry="7" fill="#267BF1" opacity="0">
                            <animate attributeName="opacity" from="0" to="0.35" dur="0.35s" begin="0.3s" fill="freeze"/>
                        </ellipse>
                        <ellipse cx="50" cy="46" rx="26" ry="7" fill="#267BF1" opacity="0">
                            <animate attributeName="opacity" from="0" to="0.55" dur="0.35s" begin="0.5s" fill="freeze"/>
                        </ellipse>
                        <ellipse cx="50" cy="38" rx="26" ry="7" fill="#267BF1" opacity="0">
                            <animate attributeName="opacity" from="0" to="0.75" dur="0.35s" begin="0.7s" fill="freeze"/>
                        </ellipse>
                        <ellipse cx="50" cy="30" rx="26" ry="7" fill="#267BF1" opacity="0">
                            <animate attributeName="opacity" from="0" to="0.9" dur="0.35s" begin="0.9s" fill="freeze"/>
                        </ellipse>
                        <text x="40" y="35" font-size="11" font-weight="700" fill="white" font-family="monospace" opacity="0">€
                            <animate attributeName="opacity" from="0" to="1" dur="0.3s" begin="1.1s" fill="freeze"/>
                        </text>
                    </svg>
                    @else
                    {{-- Anneau de progression --}}
                    <svg viewBox="0 0 70 70" xmlns="http://www.w3.org/2000/svg" style="width:70px;height:70px;" aria-hidden="true">
                        <circle cx="35" cy="35" r="27" fill="none" stroke="#267BF1" stroke-width="7" opacity="0.1"/>
                        <circle cx="35" cy="35" r="27" fill="none" stroke="#267BF1" stroke-width="7"
                            stroke-dasharray="170" stroke-dashoffset="170" stroke-linecap="round"
                            transform="rotate(-90 35 35)">
                            <animate attributeName="stroke-dashoffset" from="170" to="42" dur="1.5s" begin="0.3s" fill="freeze" calcMode="spline" keySplines="0.4 0 0.2 1"/>
                        </circle>
                        <text x="35" y="40" text-anchor="middle" font-size="12" font-weight="700" fill="#267BF1" font-family="monospace" opacity="0">75%
                            <animate attributeName="opacity" from="0" to="1" dur="0.4s" begin="1.6s" fill="freeze"/>
                        </text>
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
