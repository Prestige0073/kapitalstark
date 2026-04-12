<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') — KapitalStark</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16.png') }}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('favicon-192.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="preload" href="{{ asset('css/admin.css') }}" as="style">
    <link rel="preload" href="{{ asset('css/fonts.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('styles')
</head>
<body class="admin-body">

<div class="admin-layout">

    {{-- ── Sidebar ────────────────────────────────────────── --}}
    <aside class="admin-sidebar" id="admin-sidebar">
        <a href="{{ route('admin.index') }}" class="admin-sidebar__logo" translate="no">
            <div class="admin-sidebar__logo-wordmark">
                <span class="logo-kapital">Kapital</span><span class="logo-sep" aria-hidden="true"></span><span class="logo-stark">Stark</span>
            </div>
            <span class="admin-sidebar__logo-sub">Administration</span>
        </a>

        <nav class="admin-nav">
            <p class="admin-nav__section">Tableau de bord</p>
            <a href="{{ route('admin.index') }}" class="admin-nav__link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Vue d'ensemble
            </a>

            <p class="admin-nav__section">Prêts</p>
            <a href="{{ route('admin.requests') }}" class="admin-nav__link {{ request()->routeIs('admin.requests*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Demandes
                @if($adminNavStats['pending'] > 0)
                <span class="admin-nav__badge admin-nav__badge--red">{{ $adminNavStats['pending'] }}</span>
                @endif
            </a>
            <a href="{{ route('admin.loans') }}" class="admin-nav__link {{ request()->routeIs('admin.loans*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Prêts actifs
            </a>

            <p class="admin-nav__section">Communication</p>
            <a href="{{ route('admin.messages') }}" class="admin-nav__link {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Messagerie
                @if($adminNavStats['messages'] > 0)
                <span class="admin-nav__badge">{{ $adminNavStats['messages'] }}</span>
                @endif
            </a>
            <a href="{{ route('admin.appointments') }}" class="admin-nav__link {{ request()->routeIs('admin.appointments*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Rendez-vous
                @if($adminNavStats['appointments'] > 0)
                <span class="admin-nav__badge">{{ $adminNavStats['appointments'] }}</span>
                @endif
            </a>
            <a href="{{ route('admin.contacts') }}" class="admin-nav__link {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.1 19.79 19.79 0 0 1 1.61 4.5 2 2 0 0 1 3.59 2.31h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.08 6.08l.97-.97a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 17z"/></svg>
                Contacts publics
                @if($adminNavStats['contacts'] + $adminNavStats['rdv_requests'] > 0)
                <span class="admin-nav__badge admin-nav__badge--red">{{ $adminNavStats['contacts'] + $adminNavStats['rdv_requests'] }}</span>
                @endif
            </a>
            <a href="{{ route('admin.chat.index') }}" class="admin-nav__link {{ request()->routeIs('admin.chat*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><circle cx="9" cy="10" r="1" fill="currentColor"/><circle cx="13" cy="10" r="1" fill="currentColor"/><circle cx="17" cy="10" r="1" fill="currentColor"/></svg>
                Chat public
                @php $chatUnread = \App\Models\ChatMessage::where('direction','visitor')->where('read',false)->count(); @endphp
                @if($chatUnread > 0)
                <span class="admin-nav__badge admin-nav__badge--red">{{ $chatUnread }}</span>
                @endif
            </a>

            <a href="{{ route('admin.documents') }}" class="admin-nav__link {{ request()->routeIs('admin.documents*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Bibliothèque
            </a>

            <p class="admin-nav__section">Opérations</p>
            <a href="{{ route('admin.transfers') }}" class="admin-nav__link {{ request()->routeIs('admin.transfers*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Virements
                @if($adminNavStats['pending_transfers'] ?? 0 > 0)
                <span class="admin-nav__badge admin-nav__badge--red">{{ $adminNavStats['pending_transfers'] }}</span>
                @endif
            </a>

            <p class="admin-nav__section">Comptes</p>
            <a href="{{ route('admin.users') }}" class="admin-nav__link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Utilisateurs
            </a>
        </nav>

        <div class="admin-sidebar__bottom">
            <a href="{{ route('dashboard.index') }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                Espace client
            </a>
        </div>
    </aside>

    {{-- ── Content ─────────────────────────────────────────── --}}
    <div class="admin-content">
        <header class="admin-topbar">
            <button class="admin-topbar__burger" id="admin-sidebar-open" aria-label="Ouvrir le menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div class="admin-topbar__title">@yield('title', 'Administration')</div>
            <div class="admin-topbar__user">
                <span>{{ Auth::user()->name }}</span>
                <div class="admin-topbar__avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="button" class="admin-topbar__logout"
                            onclick="adminConfirm(this, 'Voulez-vous vraiment vous déconnecter ?')"
                            aria-label="Déconnexion">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </form>
            </div>
        </header>

        @include('partials.feedback-modal')

        <main class="admin-main">
            @yield('content')
        </main>
    </div>

</div>

{{-- ── Admin Confirm Modal ───────────────────────────────── --}}
<div class="acm" id="acm" role="dialog" aria-modal="true" aria-labelledby="acm-title">
    <div class="acm__box">
        <div class="acm__icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <h3 class="acm__title" id="acm-title">Confirmer l'action</h3>
        <p class="acm__msg" id="acm-msg"></p>
        <div class="acm__actions">
            <button type="button" class="acm__cancel" onclick="adminConfirmCancel()">Annuler</button>
            <button type="button" class="acm__ok" onclick="adminConfirmOk()">Confirmer</button>
        </div>
    </div>
</div>

<div class="admin-overlay" id="admin-overlay"></div>

<script>
(function () {
    var sidebar  = document.getElementById('admin-sidebar');
    var overlay  = document.getElementById('admin-overlay');
    var openBtn  = document.getElementById('admin-sidebar-open');

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
    overlay?.addEventListener('click', closeSidebar);
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeSidebar();
    });
})();

/* ── Confirm Modal global ──────────────────────────────── */
var _acmForm = null;
function adminConfirm(btn, msg) {
    _acmForm = btn.closest('form');
    document.getElementById('acm-msg').textContent = msg;
    document.getElementById('acm').classList.add('open');
}
function adminConfirmCancel() {
    document.getElementById('acm').classList.remove('open');
    _acmForm = null;
}
function adminConfirmOk() {
    if (_acmForm) _acmForm.submit();
    adminConfirmCancel();
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') adminConfirmCancel();
});
document.getElementById('acm').addEventListener('click', function(e) {
    if (e.target === this) adminConfirmCancel();
});
</script>
@yield('scripts')
</body>
</html>
