<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="vapid-public-key" content="{{ config('app.vapid_public_key') }}">
    <meta name="push-subscribe-url" content="{{ route('dashboard.push.subscribe') }}">
    <meta name="push-unsubscribe-url" content="{{ route('dashboard.push.unsubscribe') }}">
    <title>@yield('title', 'Mon Espace') — KapitalStark</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16.png') }}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('favicon-192.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
    .dash-lang {
        display: flex;
        gap: 4px;
        padding: 10px 16px 8px;
        border-top: 1px solid rgba(255,255,255,0.07);
        flex-wrap: wrap;
    }
    .dash-lang__btn {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 4px 8px;
        border-radius: 6px;
        color: rgba(255,255,255,0.45);
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
        font-family: var(--font-mono, monospace);
    }
    .dash-lang__btn:hover { background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.9); }
    .dash-lang__btn.active { background: rgba(38,123,241,0.25); color: #267BF1; }
    </style>
    @yield('styles')
</head>
<body class="dash-body">

<div class="dash-layout">

    {{-- ── Sidebar ──────────────────────────────────────────── --}}
    <aside class="dash-sidebar" id="dash-sidebar">
        <div class="dash-sidebar__top">
            <a href="/" class="dash-sidebar__logo" translate="no">
                <span class="logo-kapital">Kapital</span>
                <span class="logo-sep" aria-hidden="true"></span>
                <span class="logo-stark">Stark</span>
            </a>
            <button class="dash-sidebar__close" id="sidebar-close" aria-label="{{ __('dashboard.nav.close_menu') }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- User card --}}
        <div class="dash-user-card">
            <div class="dash-user-card__avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
            <div class="dash-user-card__info">
                <strong>{{ Auth::user()->name }}</strong>
                <span>{{ __('dashboard.nav.client_since', ['year' => \Carbon\Carbon::parse(Auth::user()->created_at)->format('Y')]) }}</span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="dash-nav" aria-label="Navigation espace client">
            <p class="dash-nav__section">{{ __('dashboard.nav.section_main') }}</p>
            <a href="{{ route('dashboard.index') }}" class="dash-nav__link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                {{ __('dashboard.nav.dashboard') }}
            </a>
            <a href="{{ route('dashboard.loans') }}" class="dash-nav__link {{ request()->routeIs('dashboard.loans') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/><path d="M12 6v6l4 2"/></svg>
                {{ __('dashboard.nav.loans') }}
            </a>
            <a href="{{ route('dashboard.requests') }}" class="dash-nav__link {{ request()->routeIs('dashboard.requests') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                {{ __('dashboard.nav.requests') }}
                @if(!empty($navRequestCount) && $navRequestCount > 0)
                <span class="dash-nav__badge dash-nav__badge--warning">{{ $navRequestCount }}</span>
                @endif
            </a>
            <a href="{{ route('dashboard.documents') }}" class="dash-nav__link {{ request()->routeIs('dashboard.documents') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                {{ __('dashboard.nav.documents') }}
            </a>

            <a href="{{ route('dashboard.messages') }}" class="dash-nav__link {{ request()->routeIs('dashboard.messages') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                {{ __('dashboard.nav.messages') }}
                @if(!empty($navUnreadMessages) && $navUnreadMessages > 0)
                <span class="dash-nav__badge">{{ $navUnreadMessages }}</span>
                @endif
            </a>
            <a href="{{ route('dashboard.calendar') }}" class="dash-nav__link {{ request()->routeIs('dashboard.calendar') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ __('dashboard.nav.appointments') }}
                @if(!empty($navUpcomingRdv) && $navUpcomingRdv > 0)
                <span class="dash-nav__badge">{{ $navUpcomingRdv }}</span>
                @endif
            </a>

            <a href="{{ route('dashboard.transfers.index') }}" class="dash-nav__link {{ request()->routeIs('dashboard.transfers*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                {{ __('dashboard.nav.transfers') }}
            </a>
            <a href="{{ route('dashboard.card') }}" class="dash-nav__link {{ request()->routeIs('dashboard.card') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                {{ __('dashboard.nav.card') }}
            </a>
            <a href="{{ route('dashboard.receipts') }}" class="dash-nav__link {{ request()->routeIs('dashboard.receipts') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                {{ __('dashboard.nav.receipts') }}
            </a>

            <p class="dash-nav__section" style="margin-top:16px;">{{ __('dashboard.nav.section_account') }}</p>
            <a href="{{ route('dashboard.profile') }}" class="dash-nav__link {{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                {{ __('dashboard.nav.profile') }}
            </a>
            <a href="{{ route('simulator.index') }}" class="dash-nav__link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                {{ __('dashboard.nav.simulator') }}
            </a>
        </nav>

        <div class="dash-sidebar__bottom">
            {{-- Sélecteur de langue --}}
            <div class="dash-lang">
                @php $currentLocale = app()->getLocale(); @endphp
                @foreach(['fr'=>'FR','en'=>'EN','de'=>'DE','es'=>'ES','pt'=>'PT'] as $code => $label)
                <a href="{{ route('locale.switch', $code) }}"
                   class="dash-lang__btn {{ $currentLocale === $code ? 'active' : '' }}"
                   aria-label="{{ $label }}"
                   title="{{ $label }}">{{ $label }}</a>
                @endforeach
            </div>

            <button type="button" class="dash-logout"
                    onclick="dashConfirm('dash-logout-form', {{ json_encode(__('dashboard.nav.logout_confirm')) }})">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                {{ __('dashboard.nav.logout') }}
            </button>
        </div>
    </aside>

    {{-- ── Contenu ───────────────────────────────────────────── --}}
    <div class="dash-content">
        {{-- Topbar --}}
        <header class="dash-topbar">
            <button class="dash-topbar__burger" id="sidebar-open" aria-label="{{ __('dashboard.nav.open_menu') }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>

            <div class="dash-topbar__title">@yield('title', 'Tableau de bord')</div>

            <div class="dash-topbar__actions">
                <a href="{{ route('dashboard.requests.new') }}" class="btn btn-primary btn--sm dash-topbar__cta" aria-label="{{ __('dashboard.nav.new_request') }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                    <span class="dash-topbar__cta-label">{{ __('dashboard.nav.new_request') }}</span>
                </a>
                <form id="dash-logout-form" action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="button" class="dash-topbar__logout"
                            onclick="dashConfirm('dash-logout-form', {{ json_encode(__('dashboard.nav.logout_confirm')) }})"
                            aria-label="{{ __('dashboard.nav.logout') }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </form>
                <div class="dash-notif-wrap" id="notif-wrap">
                    <button class="dash-notif-btn" id="notif-toggle" aria-label="Notifications" aria-expanded="false">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        @if(!empty($navNotifs) && $navNotifs->count() > 0)
                        <span class="dash-notif-btn__dot"></span>
                        @endif
                    </button>
                    <div class="dash-notif-dropdown" id="notif-dropdown" aria-hidden="true">
                        <div class="dash-notif-dropdown__header">
                            <strong>{{ __('dashboard.nav.notifications') }}</strong>
                            @if(!empty($navNotifs) && $navNotifs->count() > 0)
                            <span class="dash-notif-dropdown__count">{{ $navNotifs->count() }}</span>
                            @endif
                        </div>
                        @if(empty($navNotifs) || $navNotifs->isEmpty())
                        <div class="dash-notif-dropdown__empty">{{ __('dashboard.nav.no_notifs') }}</div>
                        @else
                        @foreach($navNotifs as $n)
                        <a href="{{ $n['url'] }}" class="dash-notif-item">
                            <div class="dash-notif-item__icon dash-notif-item__icon--{{ $n['type'] }}">
                                @if($n['type'] === 'message')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                @else
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                                @endif
                            </div>
                            <div class="dash-notif-item__body">
                                <div class="dash-notif-item__text">{{ $n['text'] }}</div>
                                <div class="dash-notif-item__time">{{ $n['at'] }}</div>
                            </div>
                        </a>
                        @endforeach
                        @endif
                        <div class="dash-notif-dropdown__footer">
                            <a href="{{ route('dashboard.messages') }}">{{ __('dashboard.nav.see_messages') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        @include('partials.feedback-modal')

        <main class="dash-main">
            @yield('content')
        </main>
    </div>

</div>

{{-- Overlay mobile --}}
<div class="dash-overlay" id="dash-overlay"></div>

{{-- ── Confirm Modal ─────────────────────────────────────── --}}
<div class="dcm" id="dcm" role="dialog" aria-modal="true" aria-labelledby="dcm-title">
    <div class="dcm__box">
        <div class="dcm__icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <h3 class="dcm__title" id="dcm-title">{{ __('dashboard.nav.confirm_title') }}</h3>
        <p class="dcm__msg" id="dcm-msg"></p>
        <div class="dcm__actions">
            <button type="button" class="dcm__cancel" onclick="dashConfirmCancel()">{{ __('dashboard.nav.confirm_cancel') }}</button>
            <button type="button" class="dcm__ok" onclick="dashConfirmOk()">{{ __('dashboard.nav.confirm_ok') }}</button>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script>
const sidebar = document.getElementById('dash-sidebar');
const overlay = document.getElementById('dash-overlay');
const openBtn = document.getElementById('sidebar-open');
const closeBtn = document.getElementById('sidebar-close');

function openSidebar() {
    sidebar.classList.add('open');
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('open');
    document.body.style.overflow = '';
}

openBtn?.addEventListener('click', openSidebar);
closeBtn?.addEventListener('click', closeSidebar);
overlay?.addEventListener('click', closeSidebar);

/* ── Confirm Modal ───────────────────────────────────────── */
var _dcmForm = null;
function dashConfirm(formId, msg) {
    _dcmForm = document.getElementById(formId);
    document.getElementById('dcm-msg').textContent = msg;
    document.getElementById('dcm').style.display = 'flex';
}
function dashConfirmCancel() {
    document.getElementById('dcm').style.display = 'none';
    _dcmForm = null;
}
function dashConfirmOk() {
    if (_dcmForm) _dcmForm.submit();
    dashConfirmCancel();
}
document.getElementById('dcm').addEventListener('click', function(e) {
    if (e.target === this) dashConfirmCancel();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && document.getElementById('dcm').style.display === 'flex') dashConfirmCancel();
});

// Notification dropdown
(function () {
    var toggle = document.getElementById('notif-toggle');
    var dropdown = document.getElementById('notif-dropdown');
    var wrap = document.getElementById('notif-wrap');
    if (!toggle || !dropdown) return;

    toggle.addEventListener('click', function (e) {
        e.stopPropagation();
        var open = dropdown.classList.toggle('open');
        toggle.setAttribute('aria-expanded', open);
        dropdown.setAttribute('aria-hidden', !open);
    });

    document.addEventListener('click', function (e) {
        if (!wrap.contains(e.target)) {
            dropdown.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
            dropdown.setAttribute('aria-hidden', 'true');
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            dropdown.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });
})();

{{-- ── Toast notification ─────────────────────────────────── --}}
(function () {
    var POLL_URL   = '{{ route("dashboard.notifs.poll") }}';
    var CSRF       = document.querySelector('meta[name=csrf-token]')?.content || '';
    var dot        = document.querySelector('.dash-notif-btn__dot');
    var dropdown   = document.getElementById('notif-dropdown');
    var lastUnread = {{ (!empty($navNotifs) && $navNotifs->count() > 0) ? $navNotifs->count() : 0 }};

    /* ── Toast DOM ───────────────────────────────────── */
    var toastWrap = document.createElement('div');
    toastWrap.id = 'dash-toast-wrap';
    toastWrap.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:10px;pointer-events:none;';
    document.body.appendChild(toastWrap);

    function showToast(text, url, type) {
        var t = document.createElement('div');
        t.style.cssText = 'background:#1a2540;color:#e2e8f0;padding:14px 18px;border-radius:12px;font-size:13px;max-width:320px;pointer-events:all;display:flex;align-items:flex-start;gap:12px;box-shadow:0 8px 32px rgba(0,0,0,.35);border-left:3px solid #267BF1;opacity:0;transform:translateY(12px);transition:opacity .25s,transform .25s;cursor:pointer;';
        var icon = type === 'message'
            ? '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#267BF1" stroke-width="2" style="flex-shrink:0;margin-top:1px"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>'
            : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#267BF1" stroke-width="2" style="flex-shrink:0;margin-top:1px"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>';
        t.innerHTML = icon + '<span>' + text + '</span>';
        t.addEventListener('click', function () { if (url) window.location = url; });
        toastWrap.appendChild(t);
        requestAnimationFrame(function () {
            t.style.opacity = '1';
            t.style.transform = 'translateY(0)';
        });
        setTimeout(function () {
            t.style.opacity = '0';
            t.style.transform = 'translateY(12px)';
            setTimeout(function () { t.remove(); }, 300);
        }, 5000);
    }

    /* ── Update bell badge ───────────────────────────── */
    function updateBell(unread, items) {
        if (!dot) {
            /* Créer le dot s'il n'existe pas */
            var btn = document.getElementById('notif-toggle');
            if (btn && unread > 0) {
                var d = document.createElement('span');
                d.className = 'dash-notif-btn__dot';
                btn.appendChild(d);
            }
        } else {
            dot.style.display = unread > 0 ? '' : 'none';
        }

        /* Mettre à jour le compteur dans le header du dropdown */
        if (dropdown) {
            var countEl = dropdown.querySelector('.dash-notif-dropdown__count');
            var header  = dropdown.querySelector('.dash-notif-dropdown__header strong');
            if (unread > 0) {
                if (!countEl && header) {
                    countEl = document.createElement('span');
                    countEl.className = 'dash-notif-dropdown__count';
                    header.parentNode.appendChild(countEl);
                }
                if (countEl) countEl.textContent = unread;
            } else if (countEl) {
                countEl.remove();
            }
        }
    }

    /* ── Poll every 5s ───────────────────────────────── */
    setInterval(function () {
        fetch(POLL_URL, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': CSRF } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                var newUnread = data.unread || 0;
                if (newUnread > lastUnread) {
                    /* Nouveaux messages — afficher toast pour chaque nouveau */
                    var diff = newUnread - lastUnread;
                    (data.items || []).slice(0, diff).forEach(function (n) {
                        showToast(n.text, n.url, n.type);
                    });
                }
                lastUnread = newUnread;
                updateBell(newUnread, data.items || []);
            })
            .catch(function () {});
    }, 5000);
})();
</script>
@yield('scripts')
<script>
/* ── Service Worker + Push Notifications ──────────────────── */
(function () {
    if (!('serviceWorker' in navigator) || !('PushManager' in window)) return;

    var VAPID_PUB   = document.querySelector('meta[name=vapid-public-key]')?.content;
    var SUB_URL     = document.querySelector('meta[name=push-subscribe-url]')?.content;
    var UNSUB_URL   = document.querySelector('meta[name=push-unsubscribe-url]')?.content;
    var CSRF        = document.querySelector('meta[name=csrf-token]')?.content || '';

    if (!VAPID_PUB || !SUB_URL) return;

    function urlBase64ToUint8Array(base64String) {
        var padding = '='.repeat((4 - (base64String.length % 4)) % 4);
        var base64  = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
        var raw     = atob(base64);
        var arr     = new Uint8Array(raw.length);
        for (var i = 0; i < raw.length; i++) arr[i] = raw.charCodeAt(i);
        return arr;
    }

    navigator.serviceWorker.register('/sw.js').then(function (reg) {
        /* Vérifier si déjà abonné */
        reg.pushManager.getSubscription().then(function (existing) {
            if (existing) return; /* Déjà abonné — rien à faire */

            /* Demander permission seulement si pas encore accordée */
            if (Notification.permission === 'granted') {
                subscribe(reg);
            } else if (Notification.permission !== 'denied') {
                /* Déclencher après 3s pour ne pas bloquer le chargement */
                setTimeout(function () {
                    Notification.requestPermission().then(function (perm) {
                        if (perm === 'granted') subscribe(reg);
                    });
                }, 3000);
            }
        });
    }).catch(function () {});

    function subscribe(reg) {
        reg.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(VAPID_PUB),
        }).then(function (sub) {
            var json = sub.toJSON();
            fetch(SUB_URL, {
                method:  'POST',
                headers: {
                    'Content-Type':     'application/json',
                    'X-CSRF-TOKEN':     CSRF,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    endpoint: sub.endpoint,
                    p256dh:   json.keys.p256dh,
                    auth:     json.keys.auth,
                }),
            });
        }).catch(function () {});
    }
})();
</script>
</body>
</html>
