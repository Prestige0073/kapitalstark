<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $seoTitle = isset($seoSettings) && $seoSettings?->meta_title ? $seoSettings->meta_title : null;
        $seoDesc  = isset($seoSettings) && $seoSettings?->meta_description ? $seoSettings->meta_description : null;
        $seoRobots = isset($seoSettings) && $seoSettings?->robots_directive ? $seoSettings->robots_directive : 'index, follow';
    @endphp
    <title>{{ $seoTitle ?? (View::hasSection('title') ? View::getSection('title') : 'KapitalStark') }} — {{ __('ui.seo.title_suffix') }}</title>
    <meta name="description" content="{{ $seoDesc ?? (View::hasSection('description') ? View::getSection('description') : __('ui.seo.desc_default')) }}">
    <meta name="robots" content="{{ $seoRobots }}">
    @if(isset($seoSettings) && $seoSettings?->keywords)
    <meta name="keywords" content="{{ $seoSettings->keywords }}">
    @endif
    @include('components.gtag', ['section' => 'head', 'pageType' => $seoPageType ?? 'generic'])

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@graph": [
        {
          "@@type": "FinancialService",
          "@@id": "{{ url('/') }}#organization",
          "name": "KapitalStark",
          "url": "{{ url('/') }}",
          "logo": "{{ asset('img/og-cover.svg') }}",
          "description": "{{ __('ui.seo.json_desc') }}",
          "telephone": "+351210001234",
          "email": "contacto@kapitalstark.pt",
          "address": {
            "@@type": "PostalAddress",
            "streetAddress": "Avenida da Liberdade, 110, 3.º andar",
            "addressLocality": "Lisboa",
            "postalCode": "1269-046",
            "addressCountry": "PT"
          },
          "areaServed": "PT",
          "currenciesAccepted": "EUR",
          "openingHours": ["Mo-Fr 08:00-19:00", "Sa 09:00-17:00"],
          "sameAs": [
            "https://www.linkedin.com/company/kapitalstark",
            "https://www.facebook.com/kapitalstark"
          ]
        },
        {
          "@@type": "WebSite",
          "@@id": "{{ url('/') }}#website",
          "url": "{{ url('/') }}",
          "name": "KapitalStark",
          "publisher": { "@@id": "{{ url('/') }}#organization" },
          "potentialAction": {
            "@@type": "SearchAction",
            "target": "{{ url('/faq') }}?q={search_term_string}",
            "query-input": "required name=search_term_string"
          }
        },
        {
          "@@type": "BreadcrumbList",
          "@@id": "{{ url()->current() }}#breadcrumb",
          "itemListElement": [
            { "@@type": "ListItem", "position": 1, "name": "{{ __('ui.seo.breadcrumb_home') }}", "item": "{{ url('/') }}" }
          ]
        }
      ]
    }
    </script>

    {{-- Schema supplémentaire spécifique à la page (injecté par les contrôleurs) --}}
    @yield('schema')
    @if(isset($seoSettings) && $seoSettings?->schema_json)
    <script type="application/ld+json">{!! $seoSettings->schema_json !!}</script>
    @endif

    <!-- Canonical & Open Graph -->
    <link rel="canonical" href="{{ isset($seoSettings) && $seoSettings?->canonical_url ? $seoSettings->canonical_url : url()->current() }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type"        content="website">
    <meta property="og:site_name"   content="KapitalStark">
    <meta property="og:title"       content="{{ $seoTitle ?? '' }} — {{ __('ui.seo.title_suffix') }}">
    <meta property="og:description" content="{{ $seoDesc ?? __('ui.seo.desc_default') }}">
    <meta property="og:image"       content="{{ isset($seoSettings) && $seoSettings?->og_image ? asset($seoSettings->og_image) : asset('img/og-cover.svg') }}">
    <meta property="og:locale"      content="{{ __('ui.seo.og_locale') }}">
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('title', 'KapitalStark')">
    <meta name="twitter:description" content="@yield('description', __('ui.seo.desc_default'))">
    <meta name="twitter:image"       content="{{ asset('img/og-cover.svg') }}">

    <!-- Fonts (locally embedded) -->
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">

    <!-- Favicon — toutes résolutions + manifest pour Google Search -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon-192.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16.png') }}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('favicon-192.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- CSS -->
    <link rel="preload" href="{{ asset('css/app.css') }}" as="style">
    <link rel="preload" href="{{ asset('css/fonts.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body>

    @include('components.gtag', ['section' => 'body'])

    <!-- Barre de progression scroll -->
    <div id="scroll-progress"></div>

    <!-- Header -->
    @include('partials.header')

    <!-- Contenu principal -->
    <main id="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
    @include('partials.feedback-modal')

    <!-- ── Bandeau RGPD ──────────────────────────────────────── -->
    <div id="cookie-banner" role="dialog" aria-label="{{ __('pages.cookie.title') }}" aria-modal="false" style="display:none;">
        <div class="cookie-inner">
            <div class="cookie-text">
                <p class="cookie-title">{{ __('pages.cookie.title') }}</p>
                <p class="cookie-desc">{!! __('pages.cookie.desc', ['url' => route('privacy')]) !!}</p>
            </div>
            <div class="cookie-actions">
                <button id="cookie-reject"  class="btn cookie-btn--outline">{{ __('pages.cookie.btn_reject') }}</button>
                <button id="cookie-accept"  class="btn btn-primary cookie-btn--accept">{{ __('pages.cookie.btn_accept') }}</button>
                <button id="cookie-prefs"   class="cookie-btn--prefs">{{ __('pages.cookie.btn_prefs') }}</button>
            </div>
        </div>

        {{-- Panneau personnalisation --}}
        <div id="cookie-prefs-panel" style="display:none;">
            <div class="cookie-prefs-inner">
                <p class="cookie-prefs-title">{{ __('pages.cookie.prefs_title') }}</p>
                <div class="cookie-toggle-row">
                    <div>
                        <strong>{{ __('pages.cookie.necessary_title') }}</strong>
                        <span>{{ __('pages.cookie.necessary_sub') }}</span>
                    </div>
                    <span class="cookie-toggle-always">{{ __('pages.cookie.always_active') }}</span>
                </div>
                <div class="cookie-toggle-row">
                    <div>
                        <strong>{{ __('pages.cookie.analytics_title') }}</strong>
                        <span>{{ __('pages.cookie.analytics_sub') }}</span>
                    </div>
                    <label class="cookie-switch">
                        <input type="checkbox" id="toggle-analytics" checked>
                        <span class="cookie-switch__track"></span>
                    </label>
                </div>
                <div class="cookie-toggle-row">
                    <div>
                        <strong>{{ __('pages.cookie.marketing_title') }}</strong>
                        <span>{{ __('pages.cookie.marketing_sub') }}</span>
                    </div>
                    <label class="cookie-switch">
                        <input type="checkbox" id="toggle-marketing">
                        <span class="cookie-switch__track"></span>
                    </label>
                </div>
                <div style="display:flex;gap:10px;margin-top:20px;justify-content:flex-end;">
                    <button id="cookie-prefs-cancel" class="btn cookie-btn--outline" style="padding:9px 18px;font-size:13px;">{{ __('pages.cookie.btn_cancel') }}</button>
                    <button id="cookie-save-prefs"   class="btn btn-primary" style="padding:9px 18px;font-size:13px;">{{ __('pages.cookie.btn_save') }}</button>
                </div>
            </div>
        </div>
    </div>

    <style>
    #cookie-banner {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 10000;
        background: var(--white);
        border-top: 1px solid rgba(38,123,241,0.1);
        box-shadow: 0 -4px 24px rgba(0,0,0,0.1);
        font-family: var(--font-sans);
        animation: cookieSlideUp 0.35s var(--ease-out);
    }
    @@keyframes cookieSlideUp {
        from { transform: translateY(100%); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
    }
    .cookie-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px 32px;
        display: flex;
        align-items: center;
        gap: 32px;
        flex-wrap: wrap;
    }
    .cookie-text { flex: 1; min-width: 260px; }
    .cookie-title { font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
    .cookie-desc  { font-size: 13px; color: var(--text-muted); line-height: 1.6; }
    .cookie-desc a { color: var(--blue); font-weight: 600; }
    .cookie-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; flex-shrink: 0; }
    .cookie-btn--outline {
        background: transparent;
        border: 1.5px solid rgba(38,123,241,0.25);
        color: var(--text);
        padding: 10px 20px;
        border-radius: var(--radius-sm);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s;
        font-family: var(--font-sans);
    }
    .cookie-btn--outline:hover { border-color: var(--blue); color: var(--blue); }
    .cookie-btn--accept { padding: 10px 20px; font-size: 13px; }
    .cookie-btn--prefs {
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 12px;
        cursor: pointer;
        text-decoration: underline;
        font-family: var(--font-sans);
        transition: color 0.2s;
    }
    .cookie-btn--prefs:hover { color: var(--blue); }

    #cookie-prefs-panel { border-top: 1px solid rgba(38,123,241,0.08); }
    .cookie-prefs-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 24px 32px;
    }
    .cookie-prefs-title { font-size: 14px; font-weight: 700; margin-bottom: 16px; color: var(--text); }
    .cookie-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(38,123,241,0.06);
    }
    .cookie-toggle-row strong { font-size: 13px; color: var(--text); display: block; margin-bottom: 2px; }
    .cookie-toggle-row span  { font-size: 12px; color: var(--text-muted); }
    .cookie-toggle-always { font-size: 11px; font-weight: 700; color: #22c55e; text-transform: uppercase; letter-spacing: 0.05em; flex-shrink: 0; }

    .cookie-switch { position: relative; display: inline-block; width: 42px; height: 24px; flex-shrink: 0; cursor: pointer; }
    .cookie-switch input { opacity: 0; width: 0; height: 0; }
    .cookie-switch__track {
        position: absolute;
        inset: 0;
        background: #e2e8f0;
        border-radius: 24px;
        transition: background 0.2s;
    }
    .cookie-switch__track::before {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #fff;
        top: 3px;
        left: 3px;
        transition: transform 0.2s;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }
    .cookie-switch input:checked + .cookie-switch__track { background: var(--blue); }
    .cookie-switch input:checked + .cookie-switch__track::before { transform: translateX(18px); }

    @media (max-width: 680px) {
        .cookie-inner   { flex-direction: column; align-items: flex-start; padding: 16px 20px; gap: 16px; }
        .cookie-actions { width: 100%; }
        .cookie-prefs-inner { padding: 16px 20px; }
    }
    </style>

    <script>
    (function () {
        'use strict';
        var CONSENT_KEY = 'ks_cookie_consent';
        var banner = document.getElementById('cookie-banner');
        if (localStorage.getItem(CONSENT_KEY)) return;
        setTimeout(function () { banner.style.display = ''; }, 800);

        function hideBanner() { banner.style.display = 'none'; }

        document.getElementById('cookie-accept').addEventListener('click', function () {
            localStorage.setItem(CONSENT_KEY, JSON.stringify({ analytics: true, marketing: true }));
            hideBanner();
        });
        document.getElementById('cookie-reject').addEventListener('click', function () {
            localStorage.setItem(CONSENT_KEY, JSON.stringify({ analytics: false, marketing: false }));
            hideBanner();
        });
        document.getElementById('cookie-prefs').addEventListener('click', function () {
            var panel = document.getElementById('cookie-prefs-panel');
            panel.style.display = panel.style.display === 'none' ? '' : 'none';
        });
        document.getElementById('cookie-prefs-cancel').addEventListener('click', function () {
            document.getElementById('cookie-prefs-panel').style.display = 'none';
        });
        document.getElementById('cookie-save-prefs').addEventListener('click', function () {
            localStorage.setItem(CONSENT_KEY, JSON.stringify({
                analytics: document.getElementById('toggle-analytics').checked,
                marketing: document.getElementById('toggle-marketing').checked,
            }));
            hideBanner();
        });
    })();
    </script>

    <!-- ── Chat i18n ─────────────────────────────────────────── -->
    <script>
    var CHAT_I18N = {!! json_encode([
        'advisor_name'     => __('ui.chat.advisor_name'),
        'now'              => __('ui.chat.now'),
        'suggest_1'        => __('ui.chat.suggest_1'),
        'suggest_2'        => __('ui.chat.suggest_2'),
        'suggest_3'        => __('ui.chat.suggest_3'),
        'suggest_4'        => __('ui.chat.suggest_4'),
        'msg_received'     => __('ui.chat.msg_received'),
        'msg_error'        => __('ui.chat.msg_error'),
        'notif_from'       => __('ui.chat.notif_from'),
        'responses'        => [
            __('ui.chat.suggest_1') => ['text' => __('ui.chat.resp_sim_text'),     'link' => '/simulateur',              'linkLabel' => __('ui.chat.resp_sim_link')],
            __('ui.chat.suggest_2') => ['text' => __('ui.chat.resp_rates_text')],
            __('ui.chat.suggest_3') => ['text' => __('ui.chat.resp_rdv_text'),     'link' => '/contact/rdv',             'linkLabel' => __('ui.chat.resp_rdv_link')],
            __('ui.chat.suggest_4') => ['text' => __('ui.chat.resp_space_text'),   'link' => '/espace-client/register',  'linkLabel' => __('ui.chat.resp_space_link')],
            'default'               => ['text' => __('ui.chat.resp_default_text'), 'link' => '/contact/rdv',             'linkLabel' => __('ui.chat.resp_default_link')],
        ],
    ]) !!};
    </script>

    <!-- ── Chat widget ──────────────────────────────────────── -->
    <div id="chat-widget" aria-live="polite">
        {{-- Mini popup de notification --}}
        <div id="chat-notif-bubble" style="display:none;">
            <div id="chat-notif-bubble__text"></div>
            <button id="chat-notif-bubble__close" aria-label="{{ __('ui.chat.close_aria') }}">×</button>
        </div>

        <button id="chat-launcher" aria-label="{{ __('ui.chat.open_aria') }}" aria-expanded="false" aria-controls="chat-popup">
            <span id="chat-launcher-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </span>
            <span id="chat-launcher-close" style="display:none;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </span>
            <span class="chat-launcher-dot" id="chat-dot"></span>
            <span id="chat-unread-badge" style="display:none;">0</span>
        </button>

        {{-- Popup --}}
        <div id="chat-popup" role="dialog" aria-modal="true" aria-label="{{ __('ui.chat.popup_aria') }}" style="display:none;">
            <div class="chat-popup__head">
                <div class="chat-popup__advisor">
                    <div class="chat-popup__avatar">K</div>
                    <div>
                        <p class="chat-popup__name">{{ __('ui.chat.advisor_name') }}</p>
                        <p class="chat-popup__status">
                            <span class="chat-popup__online-dot"></span>
                            {{ __('ui.chat.advisor_status') }}
                        </p>
                    </div>
                </div>
                <button class="chat-popup__minimize" id="chat-minimize" aria-label="{{ __('ui.chat.minimize_aria') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12H4"/></svg>
                </button>
            </div>

            <div class="chat-popup__body" id="chat-popup-body">
                <div class="chat-popup__msg chat-popup__msg--advisor">
                    <p>{{ __('ui.chat.welcome') }}</p>
                    <span class="chat-popup__time">{{ __('ui.chat.now') }}</span>
                </div>
                <div class="chat-popup__suggestions" id="chat-suggestions">
                    <button class="chat-popup__suggest" onclick="sendSuggestion(CHAT_I18N.suggest_1)">{{ __('ui.chat.suggest_1') }}</button>
                    <button class="chat-popup__suggest" onclick="sendSuggestion(CHAT_I18N.suggest_2)">{{ __('ui.chat.suggest_2') }}</button>
                    <button class="chat-popup__suggest" onclick="sendSuggestion(CHAT_I18N.suggest_3)">{{ __('ui.chat.suggest_3') }}</button>
                    <button class="chat-popup__suggest" onclick="sendSuggestion(CHAT_I18N.suggest_4)">{{ __('ui.chat.suggest_4') }}</button>
                </div>
            </div>

            <div class="chat-popup__input-wrap">
                <input type="text" id="chat-input" class="chat-popup__input"
                       placeholder="{{ __('ui.chat.input_ph') }}"
                       aria-label="{{ __('ui.chat.input_aria') }}"
                       onkeydown="if(event.key==='Enter')sendChatMsg()">
                <button class="chat-popup__send" onclick="sendChatMsg()" aria-label="{{ __('ui.chat.send_aria') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
        </div>
    </div>

    <style>
    #chat-widget {
        position: fixed;
        bottom: 28px;
        right: 28px;
        z-index: 9999;
        font-family: var(--font-sans);
    }

    #chat-launcher {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--blue), var(--blue-dark));
        color: #fff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(38,123,241,0.4);
        transition: transform 0.2s var(--ease), box-shadow 0.2s;
        position: relative;
        margin-left: auto;
    }

    #chat-launcher:hover {
        transform: scale(1.08);
        box-shadow: 0 6px 28px rgba(38,123,241,0.5);
    }

    .chat-launcher-dot {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 12px;
        height: 12px;
        background: #22c55e;
        border-radius: 50%;
        border: 2px solid #fff;
        animation: chatPulse 2s infinite;
    }

    @@keyframes chatPulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: 0.7; }
    }

    /* Badge non lus */
    #chat-unread-badge {
        position: absolute;
        top: -4px;
        left: -4px;
        min-width: 20px;
        height: 20px;
        padding: 0 5px;
        background: #ef4444;
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        border-radius: 10px;
        border: 2px solid #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: badgePop 0.3s var(--ease-out);
    }

    @@keyframes badgePop {
        from { transform: scale(0); }
        to   { transform: scale(1); }
    }

    /* Bulle de notification admin */
    #chat-notif-bubble {
        background: var(--white);
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.15);
        padding: 12px 14px 12px 16px;
        margin-bottom: 10px;
        max-width: 280px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        animation: chatSlideIn 0.25s var(--ease-out);
        border-left: 3px solid var(--blue);
        cursor: pointer;
    }

    #chat-notif-bubble__text {
        flex: 1;
        font-size: 13px;
        color: var(--navy);
        line-height: 1.5;
    }

    #chat-notif-bubble__text strong {
        display: block;
        font-size: 12px;
        color: var(--blue);
        margin-bottom: 3px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    #chat-notif-bubble__close {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-muted);
        font-size: 18px;
        line-height: 1;
        padding: 0;
        flex-shrink: 0;
    }

    #chat-popup {
        width: 340px;
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 8px 40px rgba(0,0,0,0.18);
        overflow: hidden;
        margin-bottom: 12px;
        animation: chatSlideIn 0.25s var(--ease-out);
    }

    @@keyframes chatSlideIn {
        from { opacity: 0; transform: translateY(16px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0)    scale(1); }
    }

    .chat-popup__head {
        background: linear-gradient(135deg, var(--navy), var(--blue-dark));
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .chat-popup__advisor { display: flex; align-items: center; gap: 12px; }

    .chat-popup__avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--blue);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
        border: 2px solid rgba(255,255,255,0.25);
        flex-shrink: 0;
    }

    .chat-popup__name {
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 2px;
    }

    .chat-popup__status {
        font-size: 11px;
        color: rgba(255,255,255,0.6);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .chat-popup__online-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #22c55e;
        display: inline-block;
        flex-shrink: 0;
    }

    .chat-popup__minimize {
        background: rgba(255,255,255,0.1);
        border: none;
        color: rgba(255,255,255,0.7);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
        flex-shrink: 0;
    }

    .chat-popup__minimize:hover { background: rgba(255,255,255,0.2); }

    .chat-popup__body {
        padding: 16px;
        max-height: 280px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background: var(--cream);
    }

    .chat-popup__msg {
        max-width: 85%;
        font-size: 13px;
        line-height: 1.55;
    }

    .chat-popup__msg p {
        padding: 10px 14px;
        border-radius: 16px;
        background: var(--white);
        color: var(--text);
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    }

    .chat-popup__msg--user {
        align-self: flex-end;
    }

    .chat-popup__msg--user p {
        background: var(--blue);
        color: #fff;
        border-bottom-left-radius: 16px;
        border-bottom-right-radius: 4px;
    }

    .chat-popup__time {
        font-size: 10px;
        color: var(--text-muted);
        margin-top: 4px;
        display: block;
        padding-inline: 4px;
    }

    .chat-popup__msg--user .chat-popup__time { text-align: right; }

    .chat-popup__suggestions {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .chat-popup__suggest {
        padding: 6px 12px;
        border-radius: 100px;
        border: 1.5px solid rgba(38,123,241,0.2);
        background: var(--white);
        color: var(--blue);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
        font-family: var(--font-sans);
    }

    .chat-popup__suggest:hover {
        background: var(--blue);
        color: #fff;
        border-color: var(--blue);
    }

    .chat-popup__input-wrap {
        display: flex;
        gap: 8px;
        align-items: center;
        padding: 12px 14px;
        border-top: 1px solid rgba(38,123,241,0.08);
        background: var(--white);
    }

    .chat-popup__input {
        flex: 1;
        border: 1.5px solid rgba(38,123,241,0.15);
        border-radius: 20px;
        padding: 9px 14px;
        font-size: 13px;
        font-family: var(--font-sans);
        color: var(--text);
        background: var(--cream);
        outline: none;
        transition: border-color 0.2s;
    }

    .chat-popup__input:focus { border-color: var(--blue); }

    .chat-popup__send {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--blue);
        color: #fff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background 0.2s;
    }

    .chat-popup__send:hover { background: var(--blue-dark); }

    .chat-typing {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 10px 14px;
        background: var(--white);
        border-radius: 16px;
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        width: fit-content;
    }

    .chat-typing-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--text-muted);
        animation: typingBounce 1.2s infinite;
    }

    .chat-typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .chat-typing-dot:nth-child(3) { animation-delay: 0.4s; }

    @@keyframes typingBounce {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-5px); }
    }

    @media (max-width: 480px) {
        #chat-widget { bottom: 16px; right: 16px; }
        #chat-popup  { width: calc(100vw - 32px); }
    }
    </style>

    <script>
    (function () {
        'use strict';

        var launcher = document.getElementById('chat-launcher');
        var popup    = document.getElementById('chat-popup');
        var iconOpen = document.getElementById('chat-launcher-icon');
        var iconClose= document.getElementById('chat-launcher-close');
        var minimize = document.getElementById('chat-minimize');
        var isOpen   = false;

        var RESPONSES = CHAT_I18N.responses;

        function openChat() {
            popup.style.display = 'block';
            iconOpen.style.display  = 'none';
            iconClose.style.display = '';
            launcher.setAttribute('aria-expanded', 'true');
            isOpen = true;
            document.getElementById('chat-input').focus();
        }

        function closeChat() {
            popup.style.display = 'none';
            iconOpen.style.display  = '';
            iconClose.style.display = 'none';
            launcher.setAttribute('aria-expanded', 'false');
            isOpen = false;
        }

        launcher.addEventListener('click', function () {
            isOpen ? closeChat() : openChat();
        });

        minimize && minimize.addEventListener('click', closeChat);

        function appendMsg(text, isUser, link, linkLabel) {
            var body = document.getElementById('chat-popup-body');
            var wrap = document.createElement('div');
            wrap.className = 'chat-popup__msg' + (isUser ? ' chat-popup__msg--user' : '');

            var now  = new Date();
            var time = now.getHours() + ':' + String(now.getMinutes()).padStart(2, '0');

            var html = '<p>' + text;
            if (link) html += ' <a href="' + link + '" style="color:' + (isUser ? 'rgba(255,255,255,0.85)' : 'var(--blue)') + ';font-weight:600;">' + linkLabel + ' →</a>';
            html += '</p><span class="chat-popup__time">' + time + '</span>';
            wrap.innerHTML = html;
            body.appendChild(wrap);
            body.scrollTop = body.scrollHeight;
        }

        function showTyping() {
            var body = document.getElementById('chat-popup-body');
            var typing = document.createElement('div');
            typing.id  = 'chat-typing-indicator';
            typing.className = 'chat-popup__msg';
            typing.innerHTML = '<div class="chat-typing"><span class="chat-typing-dot"></span><span class="chat-typing-dot"></span><span class="chat-typing-dot"></span></div>';
            body.appendChild(typing);
            body.scrollTop = body.scrollHeight;
        }

        function hideTyping() {
            var t = document.getElementById('chat-typing-indicator');
            if (t) t.remove();
        }

        function botRespond(userText) {
            var resp = RESPONSES[userText] || RESPONSES['default'];
            showTyping();
            setTimeout(function () {
                hideTyping();
                appendMsg(resp.text, false, resp.link || null, resp.linkLabel || null);
            }, 1200 + Math.random() * 600);
        }

        var lastAdminMsgId = 0;
        var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        function sendToServer(text) {
            showTyping();
            fetch('{{ route('chat.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ body: text }),
            })
            .then(function(r){ return r.json(); })
            .then(function(data){
                hideTyping();
                // Avancer lastAdminMsgId pour éviter la double affichage par le poll
                if (data.bot_id && data.bot_id > lastAdminMsgId) {
                    lastAdminMsgId = data.bot_id;
                }
                if (data.bot) {
                    appendMsg(data.bot.body, false, data.bot.link || null, data.bot.link_label || null);
                } else {
                    appendMsg(CHAT_I18N.msg_received, false, null, null);
                }
            })
            .catch(function(){
                hideTyping();
                appendMsg(CHAT_I18N.msg_error, false, null, null);
            });
        }

        var unreadCount  = 0;
        var badge        = document.getElementById('chat-unread-badge');
        var notifBubble  = document.getElementById('chat-notif-bubble');
        var notifText    = document.getElementById('chat-notif-bubble__text');
        var notifClose   = document.getElementById('chat-notif-bubble__close');
        var bubbleTimer  = null;

        function showUnreadBadge(count) {
            badge.textContent = count;
            badge.style.display = 'flex';
        }

        function clearUnreadBadge() {
            unreadCount = 0;
            badge.style.display = 'none';
            notifBubble.style.display = 'none';
        }

        function showNotifBubble(text) {
            notifText.innerHTML = '<strong>' + CHAT_I18N.notif_from + '</strong>' + text;
            notifBubble.style.display = 'flex';
            // Fermer automatiquement après 8s
            clearTimeout(bubbleTimer);
            bubbleTimer = setTimeout(function(){ notifBubble.style.display = 'none'; }, 8000);
        }

        // Cliquer sur la bulle ouvre le chat
        notifBubble.addEventListener('click', function(e) {
            if (e.target !== notifClose) {
                clearUnreadBadge();
                openChat();
            }
        });

        notifClose.addEventListener('click', function(e) {
            e.stopPropagation();
            notifBubble.style.display = 'none';
        });

        function pollAdmin() {
            fetch('{{ route('chat.poll') }}?since=' + lastAdminMsgId, {
                headers: { 'Accept': 'application/json' },
            })
            .then(function(r){ return r.json(); })
            .then(function(data){
                (data.messages || []).forEach(function(msg){
                    if (msg.id > lastAdminMsgId) {
                        lastAdminMsgId = msg.id;
                        if (isOpen) {
                            // Chat ouvert → afficher directement
                            appendMsg(msg.body, false, null, null);
                        } else {
                            // Chat fermé → badge + bulle de notification
                            unreadCount++;
                            showUnreadBadge(unreadCount);
                            showNotifBubble(msg.body.length > 80 ? msg.body.substring(0, 80) + '…' : msg.body);
                        }
                    }
                });
            })
            .catch(function(){});
        }

        // ── Polling adaptatif : 30s en arrière-plan, 5s si chat ouvert ──
        var _chatPollTimer = null;

        function startActivePoll() {
            if (_chatPollTimer) clearInterval(_chatPollTimer);
            _chatPollTimer = setInterval(pollAdmin, 5000);
        }

        function startBgPoll() {
            if (_chatPollTimer) clearInterval(_chatPollTimer);
            _chatPollTimer = setInterval(pollAdmin, 30000);
        }

        // Ouverture : passer en mode actif 5s + récupérer les messages manqués
        var _origOpenChat = openChat;
        openChat = function() {
            _origOpenChat();
            startActivePoll();
            if (unreadCount > 0) {
                fetch('{{ route('chat.poll') }}?since=0', { headers: { 'Accept': 'application/json' } })
                    .then(function(r){ return r.json(); })
                    .then(function(data){
                        (data.messages || []).forEach(function(msg){
                            if (msg.id > lastAdminMsgId) {
                                lastAdminMsgId = msg.id;
                                appendMsg(msg.body, false, null, null);
                            }
                        });
                    });
                clearUnreadBadge();
            }
        };

        // Fermeture : repasser en mode background 30s
        var _origCloseChat = closeChat;
        closeChat = function() {
            _origCloseChat();
            startBgPoll();
        };

        // Démarrer en background (chat fermé par défaut)
        startBgPoll();

        window.sendSuggestion = function (text) {
            var sugg = document.getElementById('chat-suggestions');
            if (sugg) sugg.remove();
            appendMsg(text, true);
            sendToServer(text);
        };

        window.sendChatMsg = function () {
            var input = document.getElementById('chat-input');
            var text  = input.value.trim();
            if (!text) return;
            appendMsg(text, true);
            input.value = '';
            sendToServer(text);
        };
    })();
    </script>

    @include('components.gtag', ['section' => 'events'])

</body>
</html>
