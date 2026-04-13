@extends('layouts.app')
@section('title', __('pages.titles.values'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:80px 60px;">
    <div class="container page-hero__inner">
        <nav style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:12px;">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5);">{{ __('pages.values.breadcrumb_home') }}</a>
            <span style="margin-inline:8px;">›</span>
            <a href="{{ route('about') }}" style="color:rgba(255,255,255,0.5);">{{ __('pages.values.breadcrumb_about') }}</a>
            <span style="margin-inline:8px;">›</span>
            <span>{{ __('pages.values.breadcrumb_cur') }}</span>
        </nav>
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.values.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('pages.values.hero_title') }}</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;max-width:600px;margin-inline:auto;margin-top:12px;">
            {{ __('pages.values.hero_sub') }}
        </p>
    </div>
</section>

{{-- Valeurs principales --}}
<section style="background:var(--white);">
    <div class="container">
        <div class="values-main-grid">
            @foreach(trans('pages.values.items') as $i => $val)
            <div class="card reveal stagger-{{ ($i % 2) + 1 }}" style="padding:40px;overflow:hidden;position:relative;">
                <div style="position:absolute;top:-20px;right:-20px;width:120px;height:120px;border-radius:50%;background:{{ $val['color'] }};opacity:0.06;"></div>
                <div style="width:56px;height:56px;border-radius:16px;background:{{ $val['color'] }};opacity:0.12;display:flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:20px;">
                    <span style="opacity: 8.33;">{{ $val['icon'] }}</span>
                </div>
                <span style="font-size:22px;display:block;margin-bottom:12px;">{{ $val['icon'] }}</span>
                <h2 style="font-size:26px;margin-bottom:6px;color:var(--text);">{{ $val['title'] }}</h2>
                <p style="font-size:13px;font-weight:700;color:{{ $val['color'] }};text-transform:uppercase;letter-spacing:0.06em;margin-bottom:20px;">{{ $val['sub'] }}</p>
                <p style="font-size:15px;color:var(--text-muted);line-height:1.75;margin-bottom:24px;">{{ $val['body'] }}</p>
                <ul style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($val['items'] as $item)
                    <li style="display:flex;align-items:flex-start;gap:10px;font-size:14px;color:var(--text-muted);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $val['color'] }}" stroke-width="2.5" style="flex-shrink:0;margin-top:2px;"><path d="M20 6L9 17l-5-5"/></svg>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        {{-- Chiffres clés --}}
        <div class="reveal values-stats-block" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));">
            <div style="text-align:center;margin-bottom:48px;">
                <span class="section-label" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.values.stats_label') }}</span>
                <h2 style="color:#fff;margin-top:14px;">{{ __('pages.values.stats_title') }}</h2>
            </div>
            <div class="values-stats-grid">
                @foreach(trans('pages.values.stats') as $stat)
                <div>
                    <div class="font-mono" style="font-size:36px;font-weight:700;color:#fff;margin-bottom:8px;">{{ $stat['val'] }}</div>
                    <p style="font-size:14px;color:rgba(255,255,255,0.6);">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Engagements RSE --}}
        <div class="section-header reveal" style="margin-bottom:48px;">
            <span class="section-label">{{ __('pages.values.rse_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('pages.values.rse_title') }}</h2>
        </div>
        <div class="values-rse-grid">
            @foreach(trans('pages.values.rse') as $i => $eng)
            <div class="card reveal stagger-{{ ($i % 3) + 1 }}" style="padding:28px;">
                <div style="font-size:32px;margin-bottom:14px;">{{ $eng['icon'] }}</div>
                <h3 style="font-size:17px;margin-bottom:10px;">{{ $eng['title'] }}</h3>
                <p style="font-size:14px;color:var(--text-muted);line-height:1.65;">{{ $eng['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section" style="padding-block:80px;">
    <div class="container">
        <h2 class="section-title reveal" style="color:#fff;">{{ __('pages.values.cta_title') }}</h2>
        <p class="section-desc reveal stagger-1" style="color:rgba(255,255,255,0.65);max-width:520px;margin-inline:auto;">
            {{ __('pages.values.cta_desc') }}
        </p>
        <div class="cta-section__actions reveal stagger-2">
            <a href="{{ route('simulator.index') }}" class="btn btn-primary" style="font-size:17px;padding:16px 36px;">{{ __('pages.values.cta_sim') }}</a>
            <a href="{{ route('about.careers') }}" class="btn" style="background:rgba(255,255,255,0.1);color:#fff;border:1px solid rgba(255,255,255,0.2);font-size:17px;padding:16px 36px;">{{ __('pages.values.cta_join') }}</a>
        </div>
    </div>
</section>

@endsection
