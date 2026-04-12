<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page introuvable — KapitalStark</title>
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--cream);
            padding: 40px 20px;
        }
        .error-inner {
            text-align: center;
            max-width: 560px;
        }
        .error-code {
            font-family: var(--font-mono);
            font-size: clamp(80px, 15vw, 140px);
            font-weight: 700;
            line-height: 1;
            background: linear-gradient(135deg, var(--blue), var(--blue-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }
        .error-illustration {
            font-size: 64px;
            margin-bottom: 24px;
        }
        .error-title {
            font-size: clamp(24px, 4vw, 34px);
            font-family: var(--font-serif);
            color: var(--text);
            margin-bottom: 14px;
        }
        .error-desc {
            font-size: 16px;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 36px;
        }
        .error-links {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 48px;
        }
        .error-search {
            display: flex;
            gap: 8px;
            background: var(--white);
            border: 1.5px solid rgba(38,123,241,0.15);
            border-radius: 100px;
            padding: 6px 6px 6px 20px;
            max-width: 420px;
            margin-inline: auto;
            transition: border-color 0.2s;
        }
        .error-search:focus-within { border-color: var(--blue); }
        .error-search input {
            flex: 1;
            border: none;
            background: transparent;
            font-size: 14px;
            color: var(--text);
            outline: none;
            font-family: var(--font-sans);
        }
        .error-search button {
            padding: 8px 20px;
            border-radius: 100px;
            background: var(--blue);
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            font-family: var(--font-sans);
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .error-search button:hover { background: var(--blue-dark); }
        .error-quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            margin-top: 20px;
        }
        .error-quick-link {
            padding: 7px 16px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 600;
            color: var(--blue);
            background: rgba(38,123,241,0.08);
            text-decoration: none;
            transition: background 0.2s;
        }
        .error-quick-link:hover { background: rgba(38,123,241,0.15); }
        .error-brand { display: block; margin-bottom: 40px; text-decoration: none; }
    </style>
</head>
<body>
<div class="error-page">
    <div class="error-inner">
        <a href="/" class="error-brand brand-logo">
            <span class="logo-kapital">Kapital</span>
            <span class="logo-sep" aria-hidden="true"></span>
            <span class="logo-stark">Stark</span>
        </a>

        <div class="error-code">404</div>
        <div class="error-illustration">🔍</div>
        <h1 class="error-title">Page introuvable</h1>
        <p class="error-desc">
            Oops ! La page que vous cherchez n'existe pas ou a été déplacée. Vérifiez l'URL ou revenez à l'accueil.
        </p>

        <div class="error-links">
            <a href="/" class="btn btn-primary">Retour à l'accueil</a>
            <a href="/simulateur" class="btn btn-outline">Simuler un prêt</a>
        </div>

        <p style="font-size:13px;font-weight:600;color:var(--text-muted);margin-bottom:10px;text-transform:uppercase;letter-spacing:0.07em;">
            Ou cherchez directement :
        </p>
        <div class="error-search">
            <input type="search" placeholder="Prêt immobilier, taux, simulateur…"
                   onkeydown="if(event.key==='Enter' && this.value.trim()) window.location='/blog?s='+encodeURIComponent(this.value)">
            <button onclick="var v=this.previousElementSibling.value.trim();if(v)window.location='/blog?s='+encodeURIComponent(v)">
                Rechercher
            </button>
        </div>

        <div class="error-quick-links">
            <a href="/prets/immobilier" class="error-quick-link">🏠 Prêt Immobilier</a>
            <a href="/prets/automobile" class="error-quick-link">🚗 Prêt Auto</a>
            <a href="/simulateur" class="error-quick-link">🧮 Simulateur</a>
            <a href="/faq" class="error-quick-link">❓ FAQ</a>
            <a href="/contact" class="error-quick-link">📞 Contact</a>
            <a href="/blog" class="error-quick-link">✍️ Blog</a>
        </div>
    </div>
</div>
</body>
</html>
