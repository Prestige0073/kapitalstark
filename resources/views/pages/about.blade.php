@extends('layouts.app')
@section('title', __('pages.titles.about'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark) 60%,var(--navy));">
    <div class="container page-hero__inner">
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.about.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('pages.about.hero_title') }}</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;max-width:640px;margin-inline:auto;margin-top:12px;">
            {{ __('pages.about.hero_sub') }}
        </p>
    </div>
</section>

{{-- Mission --}}
<section style="background:var(--white);">
    <div class="container">
        <div class="about-mission reveal">
            <div>
                <span class="section-label">{{ __('pages.about.mission_label') }}</span>
                <h2 style="margin-top:12px;">{{ __('pages.about.mission_title') }}</h2>
                <p style="margin-top:20px;font-size:17px;color:var(--text-muted);line-height:1.75;">{{ __('pages.about.mission_p1') }}</p>
                <p style="margin-top:16px;font-size:17px;color:var(--text-muted);line-height:1.75;">{{ __('pages.about.mission_p2') }}</p>
            </div>
            <div class="about-mission__visual">
                <div class="about-mission__img">🏦</div>
            </div>
        </div>
    </div>
</section>

{{-- Timeline --}}
<section style="background:var(--cream);">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('pages.about.timeline_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('pages.about.timeline_title') }}</h2>
        </div>
        <div class="timeline">
            @foreach(trans('pages.about.timeline') as $i => $event)
            <div class="timeline__item reveal stagger-{{ ($i % 3) + 1 }}">
                <div class="timeline__dot"></div>
                <div class="timeline__content">
                    <span class="timeline__year font-mono">{{ $event['year'] }}</span>
                    <h4>{{ $event['title'] }}</h4>
                    <p>{{ $event['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Valeurs --}}
<section style="background:var(--white);">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('pages.about.values_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('pages.about.values_title') }}</h2>
        </div>
        <div class="values-grid">
            @foreach(trans('pages.about.values_items') as $i => $v)
            <div class="value-card card reveal stagger-{{ ($i % 3) + 1 }}">
                <span style="font-size:36px;margin-bottom:16px;display:block;">{{ $v['icon'] }}</span>
                <h4>{{ $v['title'] }}</h4>
                <p style="font-size:14px;color:var(--text-muted);line-height:1.6;margin-top:8px;">{{ $v['desc'] }}</p>
            </div>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:40px;" class="reveal">
            <a href="{{ route('about.values') }}" class="btn btn-outline">{{ __('pages.about.values_cta') }}</a>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="stats">
    <div class="container">
        <div class="stats__grid">
            <div class="stat-item reveal">
                <div class="stat-item__value"><span data-count="50" data-suffix="k+">0</span></div>
                <p class="stat-item__label">{{ __('pages.about.stat1') }}</p>
            </div>
            <div class="stat-item reveal stagger-1">
                <div class="stat-item__value"><span data-count="2.4" data-suffix="Md€" data-decimals="1">0</span></div>
                <p class="stat-item__label">{{ __('pages.about.stat2') }}</p>
            </div>
            <div class="stat-item reveal stagger-2">
                <div class="stat-item__value"><span data-count="5" data-suffix="">0</span></div>
                <p class="stat-item__label">{{ __('pages.about.stat3') }}</p>
            </div>
            <div class="stat-item reveal stagger-3">
                <div class="stat-item__value"><span data-count="15">0</span></div>
                <p class="stat-item__label">{{ __('pages.about.stat4') }}</p>
            </div>
        </div>
    </div>
</section>

@endsection
