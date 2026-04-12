@php
    /* ─── Résoudre le type et le message du feedback ─────────── */
    $fbType    = null;
    $fbTitle   = null;
    $fbMessage = null;

    if (session('success')) {
        $fbType    = 'success';
        $fbTitle   = __('pages.feedback.title_success');
        $fbMessage = session('success');
    } elseif (session('rdv_success')) {
        $fbType    = 'success';
        $fbTitle   = __('pages.feedback.title_rdv');
        $fbMessage = __('pages.feedback.msg_rdv');
    } elseif (session('status')) {
        $fbType    = 'info';
        $fbTitle   = __('pages.feedback.title_info');
        $fbMessage = session('status');
    } elseif (session('info')) {
        $fbType    = 'info';
        $fbTitle   = __('pages.feedback.title_info');
        $fbMessage = session('info');
    } elseif (session('error')) {
        $fbType    = 'error';
        $fbTitle   = __('pages.feedback.title_error');
        $fbMessage = session('error');
    } elseif (isset($errors) && $errors->any()) {
        $fbType    = 'error';
        $fbTitle   = __('pages.feedback.title_validation');
        $fbMessage = $errors->first();
    }
@endphp

@if($fbType)
<div id="fb-modal" class="fb-modal fb-modal--{{ $fbType }}"
     role="dialog" aria-modal="true" aria-labelledby="fb-modal-title"
     data-type="{{ $fbType }}">

    <div class="fb-modal__overlay" id="fb-modal-overlay"></div>

    <div class="fb-modal__box">

        {{-- Icône ------------------------------------------------ --}}
        <div class="fb-modal__icon-wrap">
            @if($fbType === 'success')
            <svg class="fb-modal__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            @elseif($fbType === 'error')
            <svg class="fb-modal__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
            @else
            <svg class="fb-modal__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="8"/>
                <line x1="12" y1="12" x2="12" y2="16"/>
            </svg>
            @endif
        </div>

        {{-- Texte ------------------------------------------------ --}}
        <h2 class="fb-modal__title" id="fb-modal-title">{{ $fbTitle }}</h2>
        <p  class="fb-modal__msg">{{ $fbMessage }}</p>

        {{-- Bouton fermer ---------------------------------------- --}}
        <button class="fb-modal__btn" id="fb-modal-close" type="button">
            @if($fbType === 'success') {{ __('pages.feedback.btn_success') }}
            @elseif($fbType === 'error') {{ __('pages.feedback.btn_error') }}
            @else {{ __('pages.feedback.btn_ok') }}
            @endif
        </button>

        {{-- Barre de progression (auto-close sur success / info) -- --}}
        @if($fbType !== 'error')
        <div class="fb-modal__progress" aria-hidden="true">
            <div class="fb-modal__progress-bar" id="fb-progress-bar"></div>
        </div>
        @endif

    </div>
</div>

<script>
(function () {
    'use strict';

    var FB_BTN_SUCCESS = '{{ __('pages.feedback.btn_success') }}';
    var FB_BTN_ERROR   = '{{ __('pages.feedback.btn_error') }}';
    var FB_BTN_OK      = '{{ __('pages.feedback.btn_ok') }}';

    var modal    = document.getElementById('fb-modal');
    var overlay  = document.getElementById('fb-modal-overlay');
    var closeBtn = document.getElementById('fb-modal-close');
    var bar      = document.getElementById('fb-progress-bar');
    var type     = modal ? modal.dataset.type : null;
    var timer    = null;

    function closeFb() {
        if (!modal) return;
        modal.classList.add('fb-modal--out');
        clearTimeout(timer);
        setTimeout(function () {
            modal.style.display = 'none';
        }, 320);
    }

    /* ── Ouvrir après le paint ── */
    requestAnimationFrame(function () {
        requestAnimationFrame(function () {
            if (modal) modal.classList.add('fb-modal--visible');
        });
    });

    if (closeBtn) closeBtn.addEventListener('click', closeFb);
    if (overlay)  overlay.addEventListener('click', closeFb);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeFb();
    });

    /* ── Auto-fermeture (success & info) ── */
    if (bar && type !== 'error') {
        var DELAY = 5000; /* ms */
        /* Lance l'animation CSS */
        requestAnimationFrame(function () {
            bar.style.transition = 'width ' + DELAY + 'ms linear';
            bar.style.width = '0%';
        });
        timer = setTimeout(closeFb, DELAY);
    }

    /* ── API publique ── */
    window.showFeedback = function (t, title, msg) {
        /* Injection dynamique si besoin depuis JS */
        if (!modal) return;
        modal.dataset.type = t;
        modal.className    = 'fb-modal fb-modal--' + t;
        var titleEl = modal.querySelector('.fb-modal__title');
        var msgEl   = modal.querySelector('.fb-modal__msg');
        var btnEl   = modal.querySelector('.fb-modal__btn');
        if (titleEl) titleEl.textContent = title;
        if (msgEl)   msgEl.textContent   = msg;
        if (btnEl)   btnEl.textContent   = (t === 'success') ? FB_BTN_SUCCESS : (t === 'error') ? FB_BTN_ERROR : FB_BTN_OK;
        modal.style.display = '';
        modal.classList.remove('fb-modal--out', 'fb-modal--visible');
        requestAnimationFrame(function () {
            requestAnimationFrame(function () { modal.classList.add('fb-modal--visible'); });
        });
    };
})();
</script>
@else
{{-- Pas de message — exposer quand même l'API JS pour les pages qui l'utilisent --}}
<div id="fb-modal" class="fb-modal fb-modal--success"
     role="dialog" aria-modal="true" aria-labelledby="fb-modal-title"
     data-type="success" style="display:none">
    <div class="fb-modal__overlay" id="fb-modal-overlay"></div>
    <div class="fb-modal__box">
        <div class="fb-modal__icon-wrap">
            <svg class="fb-modal__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <h2 class="fb-modal__title" id="fb-modal-title"></h2>
        <p  class="fb-modal__msg"></p>
        <button class="fb-modal__btn" id="fb-modal-close" type="button">{{ __('pages.feedback.btn_ok') }}</button>
        <div class="fb-modal__progress" aria-hidden="true">
            <div class="fb-modal__progress-bar" id="fb-progress-bar"></div>
        </div>
    </div>
</div>
<script>
(function () {
    'use strict';

    var FB_BTN_SUCCESS = '{{ __('pages.feedback.btn_success') }}';
    var FB_BTN_ERROR   = '{{ __('pages.feedback.btn_error') }}';
    var FB_BTN_OK      = '{{ __('pages.feedback.btn_ok') }}';

    var modal    = document.getElementById('fb-modal');
    var overlay  = document.getElementById('fb-modal-overlay');
    var closeBtn = document.getElementById('fb-modal-close');
    var bar      = document.getElementById('fb-progress-bar');

    function closeFb() {
        if (!modal) return;
        modal.classList.add('fb-modal--out');
        setTimeout(function () { modal.style.display = 'none'; }, 320);
    }

    if (closeBtn) closeBtn.addEventListener('click', closeFb);
    if (overlay)  overlay.addEventListener('click', closeFb);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeFb(); });

    window.showFeedback = function (t, title, msg) {
        var DELAY = (t !== 'error') ? 5000 : null;
        modal.dataset.type = t;
        modal.className    = 'fb-modal fb-modal--' + t;
        var titleEl = modal.querySelector('.fb-modal__title');
        var msgEl   = modal.querySelector('.fb-modal__msg');
        var btnEl   = modal.querySelector('.fb-modal__btn');
        var barWrap = modal.querySelector('.fb-modal__progress');
        if (titleEl) titleEl.textContent = title;
        if (msgEl)   msgEl.textContent   = msg;
        if (btnEl)   btnEl.textContent   = (t === 'success') ? FB_BTN_SUCCESS : (t === 'error') ? FB_BTN_ERROR : FB_BTN_OK;
        if (barWrap) barWrap.style.display = (t !== 'error') ? '' : 'none';
        if (bar) { bar.style.transition = 'none'; bar.style.width = '100%'; }
        modal.style.display = '';
        modal.classList.remove('fb-modal--out', 'fb-modal--visible');
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                modal.classList.add('fb-modal--visible');
                if (bar && DELAY) {
                    bar.style.transition = 'width ' + DELAY + 'ms linear';
                    bar.style.width = '0%';
                    setTimeout(closeFb, DELAY);
                }
            });
        });
    };
})();
</script>
@endif
