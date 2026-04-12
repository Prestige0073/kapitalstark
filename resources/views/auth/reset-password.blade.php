@extends('layouts.auth')
@section('title', __('auth.reset.meta_title'))

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
            <p class="auth-quote__text">{{ __('auth.reset.quote_text') }}</p>
            <div class="auth-quote__author">
                <div class="auth-quote__avatar">NL</div>
                <div>
                    <div class="auth-quote__name">{{ __('auth.reset.quote_name') }}</div>
                    <div class="auth-quote__role">{{ __('auth.reset.quote_role') }}</div>
                </div>
            </div>
        </div>
    </aside>

    <main class="auth-form-area">
        <div class="auth-card">
            <div class="auth-card__head">
                <a href="{{ route('client.login') }}" class="auth-card__back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                    {{ __('auth.reset.back') }}
                </a>
                <h1 class="auth-card__title">{{ __('auth.reset.title') }}</h1>
                <p class="auth-card__sub">{{ __('auth.reset.sub') }}</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="auth-field">
                    <label for="rp-email">{{ __('auth.reset.email_label') }}</label>
                    <input type="email" id="rp-email" name="email"
                           placeholder="{{ __('auth.reset.email_ph') }}"
                           value="{{ old('email', $email) }}"
                           autocomplete="email" required>
                </div>

                <div class="auth-field">
                    <label for="rp-password">{{ __('auth.reset.pass_label') }}</label>
                    <div class="auth-field__pw">
                        <input type="password" id="rp-password" name="password"
                               placeholder="{{ __('auth.reset.pass_ph') }}"
                               autocomplete="new-password"
                               required minlength="8">
                        <button type="button" class="auth-field__eye" id="toggle-pw" aria-label="{{ __('auth.reset.pass_toggle') }}">
                            <svg id="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <div style="margin-top:8px;height:4px;border-radius:4px;background:rgba(38,123,241,0.1);overflow:hidden;">
                        <div id="pw-strength-fill" style="height:100%;width:0%;background:var(--blue);transition:width 0.3s,background 0.3s;border-radius:4px;"></div>
                    </div>
                </div>

                <div class="auth-field">
                    <label for="rp-confirm">{{ __('auth.reset.confirm_label') }}</label>
                    <input type="password" id="rp-confirm" name="password_confirmation"
                           placeholder="••••••••"
                           autocomplete="new-password" required>
                </div>

                <button type="submit" class="auth-btn">
                    {{ __('auth.reset.submit') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </form>

            <div class="auth-secure" style="margin-top:28px;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                {{ __('auth.reset.secure') }}
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
(function () {
    var pw   = document.getElementById('rp-password');
    var fill = document.getElementById('pw-strength-fill');
    var btn  = document.getElementById('toggle-pw');
    var icon = document.getElementById('eye-icon');

    if (pw && fill) {
        pw.addEventListener('input', function () {
            var v = pw.value, score = 0;
            if (v.length >= 8)  score++;
            if (v.length >= 12) score++;
            if (/[A-Z]/.test(v)) score++;
            if (/[0-9]/.test(v)) score++;
            if (/[^A-Za-z0-9]/.test(v)) score++;
            fill.style.width      = ((score / 5) * 100) + '%';
            fill.style.background = ['#ef4444','#f97316','#eab308','#22c55e','#16a34a'][score - 1] || 'transparent';
        });
    }

    if (btn && pw && icon) {
        btn.addEventListener('click', function () {
            var show = pw.type === 'password';
            pw.type = show ? 'text' : 'password';
            icon.innerHTML = show
                ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'
                : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        });
    }
})();
</script>
@endsection
