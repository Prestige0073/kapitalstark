@extends('layouts.app')
@section('title', __('pages.titles.team'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:80px 60px;">
    <div class="container page-hero__inner">
        <nav style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:16px;">
            <a href="{{ route('about') }}" style="color:rgba(255,255,255,0.5);text-decoration:none;">{{ __('pages.team.breadcrumb') }}</a>
            <span style="margin-inline:8px;">›</span>
            <span style="color:rgba(255,255,255,0.85);">{{ __('pages.team.breadcrumb_cur') }}</span>
        </nav>
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.team.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('pages.team.hero_title') }}</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;margin-top:12px;max-width:600px;margin-inline:auto;">
            {{ __('pages.team.hero_sub') }}
        </p>
    </div>
</section>

{{-- Direction --}}
<section style="background:var(--white);">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('pages.team.direction_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('pages.team.direction_title') }}</h2>
            <p class="section-desc reveal stagger-2">{{ __('pages.team.direction_desc') }}</p>
        </div>

        <div class="team-grid reveal">
            @foreach(trans('pages.team.members') as $m)
            <div class="team-card reveal">
                <div class="team-card__avatar">{{ $m['emoji'] }}</div>
                <div class="team-card__body">
                    <p class="team-card__name">{{ $m['name'] }}</p>
                    <p class="team-card__title">{{ $m['title'] }}</p>
                    <p class="team-card__bio">{{ $m['bio'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Conseillers --}}
<section style="background:var(--cream);">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('pages.team.advisors_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('pages.team.advisors_title') }}</h2>
            <p class="section-desc reveal stagger-2">{{ __('pages.team.advisors_desc') }}</p>
        </div>

        <div class="team-grid reveal">
            @foreach(trans('pages.team.advisors') as $m)
            <div class="team-card reveal">
                <div class="team-card__avatar">{{ $m['emoji'] }}</div>
                <div class="team-card__body">
                    <p class="team-card__name">{{ $m['name'] }}</p>
                    <p class="team-card__title">{{ $m['title'] }}</p>
                    <p class="team-card__bio">{{ $m['bio'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA recrutement --}}
<section class="cta-section" style="padding-block:80px;">
    <div class="container">
        <h2 class="section-title reveal" style="color:#fff;">{{ __('pages.team.cta_title') }}</h2>
        <p class="section-desc reveal stagger-1" style="color:rgba(255,255,255,0.65);max-width:520px;margin-inline:auto;">
            {{ __('pages.team.cta_desc') }}
        </p>
        <div class="cta-section__actions reveal stagger-2">
            <a href="{{ route('about.careers') }}" class="btn btn-primary" style="font-size:17px;padding:16px 36px;">{{ __('pages.team.cta_jobs') }}</a>
            <a href="{{ route('contact') }}" class="btn" style="background:rgba(255,255,255,0.1);color:#fff;border:1px solid rgba(255,255,255,0.2);font-size:17px;padding:16px 36px;">{{ __('pages.team.cta_contact') }}</a>
        </div>
    </div>
</section>

@endsection
