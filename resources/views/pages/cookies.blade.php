@extends('layouts.app')
@section('title', __('pages.titles.cookies'))
@section('description', 'Politique cookies de KapitalStark : types de cookies utilisés, durées, gestion de vos préférences conformément au RGPD.')
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:60px 40px;">
    <div class="container page-hero__inner">
        <nav style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:12px;">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5);">Accueil</a>
            <span style="margin-inline:8px;">›</span>
            <span>Cookies</span>
        </nav>
        <h1 style="color:#fff;">Politique de Cookies</h1>
        <p style="color:rgba(255,255,255,0.55);margin-top:8px;font-size:14px;">Dernière mise à jour : {{ date('d/m/Y') }} — Conforme recommandations CNPD</p>
    </div>
</section>

@php
$sections = [
    ['id'=>'intro',       'title'=>'1. Qu\'est-ce qu\'un cookie ?',        'content'=>'Un cookie est un petit fichier texte déposé sur votre terminal (ordinateur, smartphone, tablette) lors de votre visite sur un site web. Il permet au site de mémoriser des informations relatives à votre navigation pour améliorer votre expérience ou mesurer l\'audience du site. Les cookies sont lus uniquement par le serveur qui les a émis et ont une durée de vie limitée. Ils ne peuvent pas contenir de virus ni endommager votre équipement.'],
    ['id'=>'types',       'title'=>'2. Types de cookies utilisés',         'content'=>'<strong>🔒 Cookies strictement nécessaires</strong> (sans consentement requis)<br><br>Ces cookies sont indispensables au fonctionnement du site. Ils ne peuvent pas être désactivés. Ils incluent :<br>• <code>XSRF-TOKEN</code> / <code>kapitalstark_session</code> — gestion de la session et protection CSRF (durée : session)<br>• <code>ks_cookie_consent</code> — mémorisation de vos préférences cookies (durée : 13 mois)<br><br><hr style="border:none;border-top:1px solid rgba(38,123,241,0.1);margin:20px 0;"><br><strong>📊 Cookies analytiques</strong> (avec consentement)<br><br>Ces cookies nous permettent de mesurer l\'audience de manière anonymisée :<br>• <code>_ks_analytics</code> — pages vues, durée de session, parcours utilisateur (durée : 13 mois)<br>• Aucune donnée personnelle identifiable n\'est collectée<br><br><hr style="border:none;border-top:1px solid rgba(38,123,241,0.1);margin:20px 0;"><br><strong>🎯 Cookies marketing</strong> (avec consentement)<br><br>Ces cookies permettent de vous proposer des publicités personnalisées sur nos partenaires :<br>• <code>_ks_mkt</code> — suivi des conversions et retargeting (durée : 6 mois)<br>• Ces données peuvent être partagées avec des régies publicitaires partenaires'],
    ['id'=>'durees',      'title'=>'3. Durées de conservation',            'content'=>'<table style="width:100%;font-size:14px;border-collapse:collapse;"><thead><tr style="background:rgba(38,123,241,0.06);"><th style="padding:10px 14px;text-align:left;font-weight:700;color:var(--text);border-bottom:2px solid rgba(38,123,241,0.1);">Cookie</th><th style="padding:10px 14px;text-align:left;font-weight:700;color:var(--text);border-bottom:2px solid rgba(38,123,241,0.1);">Type</th><th style="padding:10px 14px;text-align:left;font-weight:700;color:var(--text);border-bottom:2px solid rgba(38,123,241,0.1);">Durée</th></tr></thead><tbody><tr><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);font-family:var(--font-mono);font-size:13px;">kapitalstark_session</td><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">Nécessaire</td><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">Session</td></tr><tr><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);font-family:var(--font-mono);font-size:13px;">XSRF-TOKEN</td><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">Nécessaire</td><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">2 heures</td></tr><tr><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);font-family:var(--font-mono);font-size:13px;">ks_cookie_consent</td><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">Nécessaire</td><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">13 mois</td></tr><tr><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);font-family:var(--font-mono);font-size:13px;">_ks_analytics</td><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">Analytique</td><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">13 mois</td></tr><tr><td style="padding:10px 14px;color:var(--text-muted);font-family:var(--font-mono);font-size:13px;">_ks_mkt</td><td style="padding:10px 14px;color:var(--text-muted);">Marketing</td><td style="padding:10px 14px;color:var(--text-muted);">6 mois</td></tr></tbody></table>'],
    ['id'=>'gestion',     'title'=>'4. Gérer vos préférences',             'content'=>'Vous pouvez à tout moment modifier vos préférences de cookies de trois façons :<br><br><strong>1. Via notre bandeau de gestion des cookies</strong> — en bas de chaque page du site. Cliquez sur « Personnaliser » pour ajuster vos choix cookie par cookie.<br><br><strong>2. Via les paramètres de votre navigateur</strong> — la plupart des navigateurs permettent de bloquer ou supprimer les cookies :<br>• <strong>Chrome :</strong> Paramètres → Confidentialité → Cookies<br>• <strong>Firefox :</strong> Paramètres → Vie privée → Cookies<br>• <strong>Safari :</strong> Préférences → Confidentialité → Gérer les données<br>• <strong>Edge :</strong> Paramètres → Cookies et autorisations de site<br><br><strong>3. Via votre espace client</strong> — rubrique Compte → Préférences de confidentialité.<br><br><em>Note : la désactivation des cookies nécessaires peut perturber le fonctionnement du site et votre accès à l\'espace client.</em>'],
    ['id'=>'tiers',       'title'=>'5. Cookies tiers',                     'content'=>'Notre site peut inclure des contenus ou services de partenaires tiers susceptibles de déposer leurs propres cookies. KapitalStark ne contrôle pas ces cookies et vous invite à consulter les politiques de confidentialité de ces tiers :<br><br>• <strong>Google Fonts</strong> — police de caractères, peut collecter des données de log<br>• <strong>Recaptcha</strong> (formulaires) — protection anti-spam, politique Google<br><br>KapitalStark s\'efforce de limiter au maximum le recours à des services tiers et de vous en informer clairement.'],
    ['id'=>'droits',      'title'=>'6. Vos droits',                        'content'=>'Conformément au RGPD et à la Lei n.º 58/2019 (droit portugais), vous disposez d\'un droit d\'opposition au dépôt de cookies non essentiels. Pour exercer ce droit ou pour toute question relative à notre politique cookies, contactez notre DPO : <a href="mailto:dpo@kapitalstark.pt" style="color:var(--blue);">dpo@kapitalstark.pt</a>. Vous pouvez également introduire une réclamation auprès de la <a href="https://www.cnpd.pt" style="color:var(--blue);" target="_blank" rel="noopener noreferrer">CNPD (Comissão Nacional de Proteção de Dados)</a>.'],
    ['id'=>'modification','title'=>'7. Évolution de cette politique',      'content'=>'KapitalStark se réserve le droit de modifier la présente politique de cookies à tout moment afin de refléter les évolutions légales, technologiques ou de service. Toute modification substantielle sera signalée par un bandeau visible sur le site et entraînera une nouvelle demande de consentement si les finalités des cookies venaient à évoluer.'],
];
@endphp

<section style="background:var(--white);padding-block:0 80px;">
    <div class="container" style="max-width:1080px;">

        {{-- Gestion rapide en haut --}}
        <div class="reveal" style="margin-top:40px;margin-bottom:40px;padding:24px 28px;background:rgba(38,123,241,0.04);border:1px solid rgba(38,123,241,0.12);border-radius:var(--radius-lg);display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
            <div style="flex:1;min-width:200px;">
                <strong style="font-size:15px;display:block;margin-bottom:4px;">🍪 Gérez vos préférences maintenant</strong>
                <p style="font-size:13px;color:var(--text-muted);">Vous pouvez modifier vos choix à tout moment sans conséquence sur la navigation principale.</p>
            </div>
            <button onclick="localStorage.removeItem('ks_cookie_consent');location.reload();" class="btn btn-outline" style="flex-shrink:0;font-size:13px;padding:10px 20px;">
                Réinitialiser mes choix
            </button>
            <button onclick="localStorage.setItem('ks_cookie_consent',JSON.stringify({analytics:true,marketing:true}));alert('Tous les cookies ont été acceptés.');" class="btn btn-primary" style="flex-shrink:0;font-size:13px;padding:10px 20px;">
                Tout accepter
            </button>
        </div>

        <div class="legal-layout">
            <aside class="legal-toc">
                <div class="legal-toc__inner">
                    <p class="legal-toc__title">Sommaire</p>
                    <nav>
                        @foreach($sections as $s)
                        <a class="legal-toc__link" href="#{{ $s['id'] }}">{{ $s['title'] }}</a>
                        @endforeach
                    </nav>
                </div>
            </aside>
            <div class="legal-content">
                @foreach($sections as $s)
                <div class="legal-section reveal" id="{{ $s['id'] }}">
                    <h2 class="legal-section__title">{{ $s['title'] }}</h2>
                    <div class="legal-section__body">{!! $s['content'] !!}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<style>
.legal-layout { display:grid;grid-template-columns:220px 1fr;gap:48px;padding-top:0; }
.legal-toc__inner { position:sticky;top:100px;background:rgba(38,123,241,0.03);border:1px solid rgba(38,123,241,0.1);border-radius:var(--radius-lg);padding:24px; }
.legal-toc__title { font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);margin-bottom:14px; }
.legal-toc__link { display:block;font-size:13px;color:var(--text-muted);padding:7px 10px;border-radius:8px;transition:all 0.2s;margin-bottom:2px;border-left:2px solid transparent;text-decoration:none;line-height:1.4; }
.legal-toc__link:hover { color:var(--blue);background:rgba(38,123,241,0.05); }
.legal-toc__link.active { color:var(--blue);background:rgba(38,123,241,0.08);border-left-color:var(--blue);font-weight:600; }
.legal-content { min-width:0; }
.legal-section { padding-block:36px;border-bottom:1px solid rgba(38,123,241,0.07);scroll-margin-top:110px; }
.legal-section:last-child { border-bottom:none; }
.legal-section__title { font-size:19px;font-family:var(--font-sans);font-weight:700;color:var(--text);margin-bottom:14px; }
.legal-section__body { font-size:15px;color:var(--text-muted);line-height:1.8; }
.legal-section__body strong { color:var(--text); }
.legal-section__body code { font-family:var(--font-mono);font-size:13px;background:rgba(38,123,241,0.07);padding:2px 6px;border-radius:4px;color:var(--blue); }
@media (max-width:1024px) { .legal-layout{grid-template-columns:1fr;gap:0;} .legal-toc{display:none;} }
</style>
<script>
(function(){
    'use strict';
    var links=document.querySelectorAll('.legal-toc__link');
    var observer=new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(e.isIntersecting){
                links.forEach(function(l){l.classList.remove('active');});
                var a=document.querySelector('.legal-toc__link[href="#'+e.target.id+'"]');
                if(a) a.classList.add('active');
            }
        });
    },{rootMargin:'-20% 0px -70% 0px'});
    links.forEach(function(l){
        var id=l.getAttribute('href').slice(1);
        var el=document.getElementById(id);
        if(el) observer.observe(el);
        l.addEventListener('click',function(e){e.preventDefault();if(el) el.scrollIntoView({behavior:'smooth'});});
    });
})();
</script>
@endsection
