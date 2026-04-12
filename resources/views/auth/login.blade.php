@extends('layouts.auth')
@section('title', __('auth.login.meta_title'))

@section('content')
<div class="auth-wrap">

    {{-- ── Panneau gauche ──────────────────────────────────── --}}
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
            <p class="auth-quote__text">{{ __('auth.login.quote_text') }}</p>
            <div class="auth-quote__author">
                <div class="auth-quote__avatar">ML</div>
                <div>
                    <div class="auth-quote__name">{{ __('auth.login.quote_name') }}</div>
                    <div class="auth-quote__role">{{ __('auth.login.quote_role') }}</div>
                </div>
            </div>
        </div>
    </aside>

    {{-- ── Panneau droit (formulaire) ──────────────────────── --}}
    <main class="auth-form-area">
        <div class="auth-card">

            <div class="auth-card__head">
                <a href="{{ route('home') }}" class="auth-card__back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                    {{ __('auth.login.back') }}
                </a>
                <h1 class="auth-card__title">{{ __('auth.login.title') }}</h1>
                <p class="auth-card__sub">{{ __('auth.login.sub') }}</p>
            </div>

            <form action="{{ route('client.login.post') }}" method="POST" novalidate>
                @csrf

                <div class="auth-field">
                    <label for="login-email">{{ __('auth.login.email_label') }}</label>
                    <input
                        type="email"
                        id="login-email"
                        name="email"
                        placeholder="{{ __('auth.login.email_ph') }}"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                        class="{{ $errors->has('email') ? 'is-error' : '' }}"
                    >
                </div>

                <div class="auth-field">
                    <label for="login-pass">{{ __('auth.login.pass_label') }}</label>
                    <div class="auth-field__pw">
                        <input
                            type="password"
                            id="login-pass"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                            class="{{ $errors->has('password') ? 'is-error' : '' }}"
                        >
                        <button type="button" class="auth-field__eye" id="toggle-pw" aria-label="{{ __('auth.login.pass_toggle') }}">
                            <svg id="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <div class="auth-row">
                    <label class="auth-check">
                        <input type="checkbox" name="remember">
                        <span>{{ __('auth.login.remember') }}</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="auth-forgot">{{ __('auth.login.forgot') }}</a>
                </div>

                <button type="submit" class="auth-btn">
                    {{ __('auth.login.submit') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </form>

            <div class="auth-sep"><span>{{ __('auth.login.or') }}</span></div>

            <a href="{{ route('client.register') }}" class="auth-btn-outline">
                {{ __('auth.login.create_account') }}
            </a>

            <p class="auth-footer">
                {{ __('auth.login.no_account') }}
                <a href="{{ route('simulator.index') }}">{{ __('auth.login.sim_link') }}</a>
            </p>

            <div class="auth-secure">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                {{ __('auth.login.secure') }}
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
(function () {
    const btn  = document.getElementById('toggle-pw');
    const inp  = document.getElementById('login-pass');
    const icon = document.getElementById('eye-icon');
    if (!btn || !inp) return;
    btn.addEventListener('click', function () {
        const show = inp.type === 'password';
        inp.type = show ? 'text' : 'password';
        icon.innerHTML = show
            ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'
            : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    });
})();
</script>
@endsection
