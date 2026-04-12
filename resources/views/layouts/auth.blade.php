<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KapitalStark — ' . __('ui.footer.tagline'))</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16.png') }}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('favicon-192.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts (locally embedded) -->
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @yield('styles')

    <style>
        /* Reset body pour full-viewport auth */
        body { margin: 0; background: #F5F8FF; }

        /* ── Sélecteur de langue auth ── */
        .auth-lang {
            position: fixed; top: 16px; right: 20px; z-index: 200;
            display: flex; gap: 4px; align-items: center;
        }
        .auth-lang__flag {
            font-size: 18px; line-height: 1; text-decoration: none;
            padding: 4px 6px; border-radius: 6px;
            transition: background .15s;
            opacity: .55;
        }
        .auth-lang__flag:hover  { background: rgba(38,123,241,.1); opacity: 1; }
        .auth-lang__flag.active { opacity: 1; }
        @media (max-width: 600px) { .auth-lang { top: 10px; right: 10px; } }
    </style>
</head>
<body>

@php $currentLocale = app()->getLocale(); @endphp

<nav class="auth-lang" aria-label="{{ __('ui.nav.language') }}">
    <a href="{{ route('locale.switch', 'fr') }}" class="auth-lang__flag {{ $currentLocale==='fr' ? 'active' : '' }}" title="Français">🇫🇷</a>
    <a href="{{ route('locale.switch', 'en') }}" class="auth-lang__flag {{ $currentLocale==='en' ? 'active' : '' }}" title="English">🇬🇧</a>
    <a href="{{ route('locale.switch', 'de') }}" class="auth-lang__flag {{ $currentLocale==='de' ? 'active' : '' }}" title="Deutsch">🇩🇪</a>
    <a href="{{ route('locale.switch', 'es') }}" class="auth-lang__flag {{ $currentLocale==='es' ? 'active' : '' }}" title="Español">🇪🇸</a>
    <a href="{{ route('locale.switch', 'pt') }}" class="auth-lang__flag {{ $currentLocale==='pt' ? 'active' : '' }}" title="Português">🇵🇹</a>
</nav>

@yield('content')

@include('partials.feedback-modal')
@yield('scripts')

</body>
</html>
