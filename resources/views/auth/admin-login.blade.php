<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration — KapitalStark</title>
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue:    #267BF1;
            --dark:    #0D1B2A;
            --darker:  #081322;
            --border:  rgba(255,255,255,0.08);
            --text:    #E8EDF4;
            --muted:   #8B98A8;
            --error:   #EF4444;
            --success: #22C55E;
            --gold:    #C8A951;
        }

        html, body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: var(--darker);
            color: var(--text);
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        /* Fond animé */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 800px 600px at 20% 20%, rgba(38,123,241,0.06) 0%, transparent 70%),
                radial-gradient(ellipse 600px 400px at 80% 80%, rgba(200,169,81,0.04) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Grille décorative */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(38,123,241,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(38,123,241,0.04) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        .admin-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 48px 44px;
            backdrop-filter: blur(20px);
            box-shadow:
                0 0 0 1px rgba(38,123,241,0.08),
                0 32px 64px rgba(0,0,0,0.5),
                inset 0 1px 0 rgba(255,255,255,0.06);
        }

        .admin-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .admin-logo {
            display: inline-flex;
            align-items: baseline;
            gap: 0;
            margin-bottom: 28px;
            text-decoration: none;
        }

        .admin-logo .logo-kapital {
            font-family: 'Playfair Display', Georgia, serif;
            font-weight: 700;
            font-style: italic;
            font-size: 24px;
            color: #fff;
            line-height: 1;
            letter-spacing: -0.01em;
            user-select: none;
            -webkit-user-select: none;
        }

        .admin-logo .logo-sep {
            display: inline-block;
            width: 1.5px;
            height: 16px;
            background: rgba(200,169,81,0.65);
            margin: 0 9px;
            align-self: center;
            flex-shrink: 0;
            transform: translateY(-1px);
            user-select: none;
            -webkit-user-select: none;
        }

        .admin-logo .logo-stark {
            font-family: 'Space Mono', monospace;
            font-weight: 700;
            font-size: 13px;
            color: #A8CFF7;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            align-self: center;
            line-height: 1;
            user-select: none;
            -webkit-user-select: none;
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(200,169,81,0.1);
            border: 1px solid rgba(200,169,81,0.2);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 11px;
            font-weight: 600;
            color: var(--gold);
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .admin-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            background: var(--gold);
            border-radius: 50%;
            animation: pulse-gold 2s infinite;
        }

        @keyframes pulse-gold {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.4; }
        }

        .admin-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .admin-sub {
            font-size: 14px;
            color: var(--muted);
        }

        /* Alerte erreur */
        .admin-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.25);
            color: #FCA5A5;
        }

        /* Champs */
        .admin-field {
            margin-bottom: 18px;
        }

        .admin-field label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .admin-field input {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255,255,255,0.04);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 15px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .admin-field input::placeholder { color: var(--muted); }

        .admin-field input:focus {
            border-color: var(--blue);
            background: rgba(38,123,241,0.05);
            box-shadow: 0 0 0 3px rgba(38,123,241,0.12);
        }

        .admin-field input.is-error {
            border-color: var(--error);
        }

        .admin-field__pw {
            position: relative;
        }

        .admin-field__pw input { padding-right: 48px; }

        .admin-field__eye {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 4px;
            transition: color 0.2s;
        }

        .admin-field__eye:hover { color: var(--text); }

        .admin-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--blue) 0%, #1A56B0 100%);
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
            transition: opacity 0.2s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(38,123,241,0.35);
        }

        .admin-btn:hover {
            opacity: 0.92;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(38,123,241,0.45);
        }

        .admin-btn:active {
            transform: translateY(0);
        }

        .admin-footer {
            margin-top: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 12px;
            color: var(--muted);
        }

        .admin-footer svg {
            color: var(--blue);
            flex-shrink: 0;
        }

        .admin-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--muted);
            text-decoration: none;
            margin-bottom: 32px;
            transition: color 0.2s;
        }

        .admin-back:hover { color: var(--text); }

        @media (max-width: 480px) {
            .admin-card { padding: 36px 28px; }
        }
    </style>
</head>
<body>

<div class="admin-card">

    <a href="{{ route('home') }}" class="admin-back">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Retour au site
    </a>

    <div class="admin-header">
        <a href="{{ route('home') }}" class="admin-logo" translate="no">
            <span class="logo-kapital">Kapital</span>
            <span class="logo-sep" aria-hidden="true"></span>
            <span class="logo-stark">Stark</span>
        </a>
        <div class="admin-badge">Administration</div>
        <h1 class="admin-title">Accès restreint</h1>
        <p class="admin-sub">Espace réservé aux administrateurs autorisés.</p>
    </div>

    <form action="{{ route('admin.login.post') }}" method="POST" novalidate>
        @csrf

        <div class="admin-field">
            <label for="admin-email">Identifiant</label>
            <input
                type="email"
                id="admin-email"
                name="email"
                placeholder="admin@kapitalstark.fr"
                value="{{ old('email') }}"
                autocomplete="username"
                required
                class="{{ $errors->has('email') ? 'is-error' : '' }}"
            >
        </div>

        <div class="admin-field">
            <label for="admin-pass">Mot de passe</label>
            <div class="admin-field__pw">
                <input
                    type="password"
                    id="admin-pass"
                    name="password"
                    placeholder="••••••••"
                    autocomplete="current-password"
                    required
                    class="{{ $errors->has('password') ? 'is-error' : '' }}"
                >
                <button type="button" class="admin-field__eye" id="toggle-pw" aria-label="Afficher le mot de passe">
                    <svg id="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>

        <button type="submit" class="admin-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            Accéder au panneau
        </button>
    </form>

    <div class="admin-footer">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        Accès journalisé · Agréé ACPR
    </div>

</div>

<script>
(function () {
    const btn  = document.getElementById('toggle-pw');
    const inp  = document.getElementById('admin-pass');
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

</body>
</html>
