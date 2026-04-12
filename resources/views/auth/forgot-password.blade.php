@extends('layouts.auth')
@section('title', __('auth.forgot.meta_title'))

@section('content')
<div class="auth-wrap">

    <aside class="auth-panel">
        <div class="auth-panel__ring"></div>
        <a href="/" class="auth-panel__logo brand-logo logo--white">
            <span class="logo-kapital">Kapital</span>
            <span class="logo-sep" aria-hidden="true"></span>
            <span class="logo-stark">Stark</span>
        </a>
        <div class="auth-panel__body">
            <h2 class="auth-panel__headline">
                {{ __('auth.panel.headline') }}<br>
                <em>{{ __('auth.panel.headline_em') }}</em>
            </h2>
            <div class="auth-stats">
                <div class="auth-stat">
                    <span class="auth-stat__num">{{ __('auth.panel.stat1_num') }}</span>
                    <span class="auth-stat__lbl">{{ __('auth.panel.stat1_lbl') }}</span>
                </div>
                <div class="auth-stat">
                    <span class="auth-stat__num">{{ __('auth.panel.stat2_num') }}</span>
                    <span class="auth-stat__lbl">{{ __('auth.panel.stat2_lbl') }}</span>
                </div>
                <div class="auth-stat">
                    <span class="auth-stat__num">{{ __('auth.panel.stat3_num') }}</span>
                    <span class="auth-stat__lbl">{{ __('auth.panel.stat3_lbl') }}</span>
                </div>
            </div>
        </div>
        <div class="auth-quote">
            <p class="auth-quote__text">{{ __('auth.forgot.quote_text') }}</p>
            <div class="auth-quote__author">
                <div class="auth-quote__avatar">CF</div>
                <div>
                    <div class="auth-quote__name">{{ __('auth.forgot.quote_name') }}</div>
                    <div class="auth-quote__role">{{ __('auth.forgot.quote_role') }}</div>
                </div>
            </div>
        </div>
    </aside>

    <main class="auth-form-area">
        <div class="auth-card">
            <div class="auth-card__head">
                <a href="{{ route('client.login') }}" class="auth-card__back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                    {{ __('auth.forgot.back') }}
                </a>
                <h1 class="auth-card__title">{{ __('auth.forgot.title') }}</h1>
                <p class="auth-card__sub">{{ __('auth.forgot.sub') }}</p>
            </div>

            <form action="{{ route('password.email') }}" method="POST" novalidate>
                @csrf
                <div class="auth-field">
                    <label for="fp-email">{{ __('auth.forgot.email_label') }}</label>
                    <input type="email" id="fp-email" name="email"
                           placeholder="{{ __('auth.forgot.email_ph') }}"
                           value="{{ old('email') }}"
                           autocomplete="email" required>
                </div>
                <button type="submit" class="auth-btn">
                    {{ __('auth.forgot.submit') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </form>

            <div class="auth-secure" style="margin-top:28px;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                {{ __('auth.forgot.secure') }}
            </div>
        </div>
    </main>
</div>
@endsection
