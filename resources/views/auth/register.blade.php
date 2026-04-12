@extends('layouts.auth')
@section('title', __('auth.register.meta_title'))

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
                {{ __('auth.register.panel_headline_1') }}<br>
                <em>{{ __('auth.register.panel_headline_em') }}</em><br>
                {{ __('auth.register.panel_headline_2') }}
            </h2>

            <div class="auth-stats">
                <div class="auth-stat">
                    <span class="auth-stat__num">{{ __('auth.register.stat1_num') }}</span>
                    <span class="auth-stat__lbl">{{ __('auth.register.stat1_lbl') }}</span>
                </div>
                <div class="auth-stat">
                    <span class="auth-stat__num">{{ __('auth.register.stat2_num') }}</span>
                    <span class="auth-stat__lbl">{{ __('auth.register.stat2_lbl') }}</span>
                </div>
                <div class="auth-stat">
                    <span class="auth-stat__num">{{ __('auth.register.stat3_num') }}</span>
                    <span class="auth-stat__lbl">{{ __('auth.register.stat3_lbl') }}</span>
                </div>
            </div>
        </div>

        <div class="auth-quote">
            <p class="auth-quote__text">{{ __('auth.register.quote_text') }}</p>
            <div class="auth-quote__author">
                <div class="auth-quote__avatar">TD</div>
                <div>
                    <div class="auth-quote__name">{{ __('auth.register.quote_name') }}</div>
                    <div class="auth-quote__role">{{ __('auth.register.quote_role') }}</div>
                </div>
            </div>
        </div>
    </aside>

    {{-- ── Panneau droit (formulaire) ──────────────────────── --}}
    <main class="auth-form-area">
        <div class="auth-card">

            <div class="auth-card__head">
                <a href="{{ route('client.login') }}" class="auth-card__back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                    {{ __('auth.register.back') }}
                </a>
                <h1 class="auth-card__title">{{ __('auth.register.title') }}</h1>
                <p class="auth-card__sub">{{ __('auth.register.sub') }}</p>
            </div>

            <form action="{{ route('client.register.post') }}" method="POST" novalidate>
                @csrf

                <div class="auth-field">
                    <label for="reg-name">{{ __('auth.register.name_label') }}</label>
                    <input
                        type="text"
                        id="reg-name"
                        name="name"
                        placeholder="{{ __('auth.register.name_ph') }}"
                        value="{{ old('name') }}"
                        autocomplete="name"
                        required
                        class="{{ $errors->has('name') ? 'is-error' : '' }}"
                    >
                    @error('name')
                    <span class="auth-field__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="reg-email">{{ __('auth.register.email_label') }}</label>
                    <input
                        type="email"
                        id="reg-email"
                        name="email"
                        placeholder="{{ __('auth.register.email_ph') }}"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                        class="{{ $errors->has('email') ? 'is-error' : '' }}"
                    >
                    @error('email')
                    <span class="auth-field__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="reg-pass">{{ __('auth.register.pass_label') }}</label>
                    <div class="auth-field__pw">
                        <input
                            type="password"
                            id="reg-pass"
                            name="password"
                            placeholder="{{ __('auth.register.pass_ph') }}"
                            autocomplete="new-password"
                            required
                            class="{{ $errors->has('password') ? 'is-error' : '' }}"
                        >
                        <button type="button" class="auth-field__eye" id="toggle-pw" aria-label="{{ __('auth.register.pass_toggle') }}">
                            <svg id="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password')
                    <span class="auth-field__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="reg-pass-confirm">{{ __('auth.register.confirm_label') }}</label>
                    <input
                        type="password"
                        id="reg-pass-confirm"
                        name="password_confirmation"
                        placeholder="••••••••"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <div class="auth-terms">
                    <input type="checkbox" id="reg-terms" name="terms" required>
                    <label for="reg-terms">
                        {!! __('auth.register.terms', ['terms_url' => route('terms'), 'privacy_url' => route('privacy')]) !!}
                    </label>
                </div>

                <button type="submit" class="auth-btn">
                    {{ __('auth.register.submit') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </form>

            <p class="auth-footer">
                {{ __('auth.register.already') }} <a href="{{ route('client.login') }}">{{ __('auth.register.login_link') }}</a>
            </p>

            <div class="auth-secure">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                {{ __('auth.register.secure') }}
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
(function () {
    var TERMS_ERR_TITLE = '{{ __('auth.register.terms_err_title') }}';
    var TERMS_ERR_MSG   = '{{ __('auth.register.terms_err_msg') }}';

    var btn  = document.getElementById('toggle-pw');
    var inp  = document.getElementById('reg-pass');
    var icon = document.getElementById('eye-icon');
    if (btn && inp) {
        btn.addEventListener('click', function () {
            var show = inp.type === 'password';
            inp.type = show ? 'text' : 'password';
            icon.innerHTML = show
                ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'
                : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        });
    }

    var form  = document.querySelector('form');
    var terms = document.getElementById('reg-terms');
    if (form && terms) {
        form.addEventListener('submit', function (e) {
            if (!terms.checked) {
                e.preventDefault();
                if (window.showFeedback) {
                    showFeedback('error', TERMS_ERR_TITLE, TERMS_ERR_MSG);
                }
                var wrap = terms.closest('.auth-terms');
                if (wrap) {
                    wrap.style.outline = '2px solid #e53e3e';
                    wrap.style.borderRadius = '6px';
                    wrap.style.padding = '4px 6px';
                    setTimeout(function () { wrap.style.outline = ''; wrap.style.padding = ''; }, 2500);
                }
            }
        });
        terms.addEventListener('change', function () {
            var wrap = terms.closest('.auth-terms');
            if (wrap) wrap.style.outline = '';
        });
    }
})();
</script>
@endsection
