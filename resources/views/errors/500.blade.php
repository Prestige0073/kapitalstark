<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erreur serveur — KapitalStark</title>
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--navy) 0%, var(--blue-dark) 100%);
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
            color: rgba(255,255,255,0.15);
            margin-bottom: 8px;
        }
        .error-illustration { font-size: 64px; margin-bottom: 24px; }
        .error-title {
            font-size: clamp(24px, 4vw, 34px);
            font-family: var(--font-serif);
            color: #fff;
            margin-bottom: 14px;
        }
        .error-desc {
            font-size: 16px;
            color: rgba(255,255,255,0.6);
            line-height: 1.7;
            margin-bottom: 36px;
        }
        .error-links {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 36px;
        }
        .error-contact {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 16px;
            padding: 20px 28px;
            font-size: 14px;
            color: rgba(255,255,255,0.6);
        }
        .error-contact a {
            color: var(--blue-light);
            font-weight: 600;
        }
        .error-brand { display: block; margin-bottom: 40px; text-decoration: none; }
    </style>
</head>
<body>
<div class="error-page">
    <div class="error-inner">
        <a href="/" class="error-brand brand-logo logo--white">
            <span class="logo-kapital">Kapital</span>
            <span class="logo-sep" aria-hidden="true"></span>
            <span class="logo-stark">Stark</span>
        </a>

        <div class="error-code">500</div>
        <div class="error-illustration">⚙️</div>
        <h1 class="error-title">Erreur serveur</h1>
        <p class="error-desc">
            Une erreur inattendue s'est produite. Notre équipe technique a été notifiée et travaille à résoudre le problème. Veuillez réessayer dans quelques instants.
        </p>

        <div class="error-links">
            <a href="/" class="btn btn-primary">Retour à l'accueil</a>
            <a href="javascript:location.reload()" class="btn" style="background:rgba(255,255,255,0.12);color:#fff;border:1px solid rgba(255,255,255,0.2);">
                Réessayer
            </a>
        </div>

        <div class="error-contact">
            Si le problème persiste, contactez notre support :<br>
            <a href="mailto:support@kapitalstark.fr">support@kapitalstark.fr</a> &nbsp;·&nbsp;
            <a href="tel:+33142000001">01 42 00 00 01</a>
        </div>
    </div>
</div>
</body>
</html>
