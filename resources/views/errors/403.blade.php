<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accès refusé — KapitalStark</title>
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .error-page{min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--cream);padding:40px 20px;}
        .error-inner{text-align:center;max-width:520px;}
        .error-code{font-family:var(--font-mono);font-size:clamp(80px,15vw,140px);font-weight:700;line-height:1;background:linear-gradient(135deg,var(--gold),var(--blue));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:8px;}
        .error-illustration{font-size:64px;margin-bottom:24px;}
        .error-title{font-size:clamp(24px,4vw,34px);font-family:var(--font-serif);color:var(--text);margin-bottom:14px;}
        .error-desc{font-size:16px;color:var(--text-muted);line-height:1.7;margin-bottom:36px;}
        .error-links{display:flex;gap:12px;justify-content:center;flex-wrap:wrap;}
        .error-brand{display:block;margin-bottom:40px;text-decoration:none;}
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
        <div class="error-code">403</div>
        <div class="error-illustration">🔒</div>
        <h1 class="error-title">Accès refusé</h1>
        <p class="error-desc">
            Vous n'avez pas les permissions nécessaires pour accéder à cette page. Connectez-vous à votre espace client ou revenez à l'accueil.
        </p>
        <div class="error-links">
            <a href="/" class="btn btn-primary">Retour à l'accueil</a>
            <a href="/espace-client" class="btn btn-outline">Se connecter</a>
        </div>
    </div>
</div>
</body>
</html>
