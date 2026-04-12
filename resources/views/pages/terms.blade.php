@extends('layouts.app')
@section('title', __('pages.titles.terms'))
@section('description', 'CGU de KapitalStark : conditions d\'accès au site, utilisation des services de simulation, espace client, cookies et droit applicable (droit portugais).')
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:60px 40px;">
    <div class="container page-hero__inner">
        <nav style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:12px;">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5);">Accueil</a>
            <span style="margin-inline:8px;">›</span>
            <span>CGU</span>
        </nav>
        <h1 style="color:#fff;">Conditions Générales d'Utilisation</h1>
        <p style="color:rgba(255,255,255,0.55);margin-top:8px;font-size:14px;">Dernière mise à jour : {{ date('d/m/Y') }} — Version 3.2</p>
    </div>
</section>

@php
$sections = [
    ['id'=>'objet',        'title'=>'1. Objet et champ d\'application', 'content'=>'Les présentes Conditions Générales d\'Utilisation (CGU) ont pour objet de définir les modalités et conditions d\'utilisation du site <strong>kapitalstark.pt</strong> (ci-après "le Site") et des services proposés par KapitalStark, S.A. (ci-après "KapitalStark"), société de droit portugais immatriculée sous le NIF 506 789 123, dont le siège est Avenida da Liberdade, 110, 3.º andar, 1269-046 Lisboa. Tout accès ou utilisation du Site implique l\'acceptation pleine, entière et sans réserve des présentes CGU. Si vous n\'acceptez pas ces conditions, vous devez cesser d\'utiliser le Site immédiatement.'],
    ['id'=>'acces',        'title'=>'2. Accès au site',                 'content'=>'Le Site est accessible gratuitement 24h/24, 7j/7, sous réserve des cas de force majeure, de maintenance planifiée ou non, de panne informatique, ou de tout événement hors du contrôle de KapitalStark. KapitalStark se réserve le droit d\'interrompre, de modifier ou de suspendre temporairement l\'accès au Site, notamment pour des opérations de maintenance, de mise à jour ou d\'amélioration des services, sans que cela ne puisse engager sa responsabilité.'],
    ['id'=>'services',     'title'=>'3. Services de simulation',        'content'=>'Les simulations et estimations fournies sur ce Site sont exclusivement indicatives et non contractuelles. Elles sont calculées sur la base des informations saisies par l\'utilisateur et des taux en vigueur à la date de la simulation. Ces résultats ne constituent en aucun cas une offre de prêt, un accord de principe ou un engagement de la part de KapitalStark. Toute demande de financement fera l\'objet d\'une étude personnalisée par nos conseillers, qui prendra en compte l\'ensemble de votre situation financière.'],
    ['id'=>'espace-client','title'=>'4. Espace Client',                 'content'=>'L\'accès à l\'Espace Client est réservé aux personnes physiques majeures ayant créé un compte sur le Site. L\'utilisateur est seul responsable de la confidentialité de ses identifiants de connexion (email et mot de passe) et de toute activité réalisée sous son compte. En cas de perte ou d\'utilisation non autorisée de ses identifiants, l\'utilisateur doit en informer immédiatement KapitalStark. KapitalStark se réserve le droit de suspendre ou de résilier tout compte en cas d\'utilisation frauduleuse ou non conforme aux présentes CGU.'],
    ['id'=>'donnees',      'title'=>'5. Données personnelles et RGPD',  'content'=>'Le traitement des données à caractère personnel collectées sur ce Site est décrit dans notre <a href="' . route('privacy') . '" style="color:var(--blue);">Politique de Confidentialité</a>. Conformément au Règlement (UE) 2016/679 (RGPD) et à la Lei n.º 58/2019 (loi portugaise de mise en œuvre du RGPD), vous disposez d\'un droit d\'accès, de rectification, d\'effacement, de portabilité et d\'opposition. Pour exercer ces droits, contactez notre DPO : <a href="mailto:dpo@kapitalstark.pt" style="color:var(--blue);">dpo@kapitalstark.pt</a>.'],
    ['id'=>'cookies',      'title'=>'6. Cookies',                       'content'=>'Le Site utilise des cookies techniques, strictement nécessaires à son fonctionnement (session, sécurité CSRF), qui ne nécessitent pas votre consentement. Des cookies analytiques (mesure d\'audience anonymisée) et marketing peuvent être déposés avec votre accord explicite, via le bandeau de gestion des cookies. Vous pouvez modifier vos préférences à tout moment via ce bandeau ou les paramètres de votre navigateur.'],
    ['id'=>'pi',           'title'=>'7. Propriété intellectuelle',      'content'=>'L\'ensemble des éléments constituant le Site (architecture, code source, textes, graphiques, logo, images, sons, vidéos) est protégé par les droits de propriété intellectuelle et appartient à KapitalStark SAS ou à ses partenaires sous licence. Aucun élément de ce Site ne peut être reproduit, modifié, publié ou transmis sans autorisation préalable écrite de KapitalStark SAS, à l\'exception d\'une utilisation à des fins strictement personnelles et non commerciales.'],
    ['id'=>'responsabilite','title'=>'8. Limitation de responsabilité', 'content'=>'KapitalStark SAS met tout en œuvre pour maintenir le Site en bon état de fonctionnement mais ne peut garantir que le Site sera exempt d\'erreurs, de virus ou d\'interruptions. La responsabilité de KapitalStark ne saurait être engagée pour : (1) les interruptions ou pannes techniques, (2) les dommages résultant de l\'utilisation du Site par l\'utilisateur, (3) les inexactitudes ou omissions dans les informations publiées, (4) les dommages causés par des tiers accédant frauduleusement au Site.'],
    ['id'=>'modification', 'title'=>'9. Modification des CGU',          'content'=>'KapitalStark SAS se réserve le droit de modifier les présentes CGU à tout moment, notamment pour prendre en compte toute évolution légale, réglementaire, jurisprudentielle ou technologique. Les utilisateurs seront informés de toute modification substantielle par email ou par un bandeau de notification sur le Site. La poursuite de l\'utilisation du Site après modification vaut acceptation des nouvelles CGU.'],
    ['id'=>'droit',        'title'=>'10. Droit applicable et juridiction','content'=>'Les présentes CGU sont soumises au droit portugais. En cas de litige relatif à leur interprétation ou à leur exécution, les parties s\'engagent à rechercher une solution amiable, notamment via le Centro de Arbitragem de Conflitos de Consumo (CACCL) ou la plateforme européenne de résolution des litiges en ligne (ODR). À défaut, tout litige sera soumis à la compétence exclusive des tribunaux de Lisboa, sous réserve des dispositions impératives du droit de la consommation (Lei de Defesa do Consumidor, Lei n.º 24/96) applicables aux consommateurs.'],
    ['id'=>'contact-cgu',  'title'=>'11. Contact',                      'content'=>'Pour toute question relative aux présentes CGU : <a href="mailto:juridico@kapitalstark.pt" style="color:var(--blue);">juridico@kapitalstark.pt</a> — KapitalStark, S.A., Avenida da Liberdade, 110, 3.º andar, 1269-046 Lisboa, Portugal.'],
];
@endphp

<section style="background:var(--white);padding-block:0 80px;">
    <div class="container" style="max-width:1080px;">
        <div class="legal-layout">
            <aside class="legal-toc" id="legal-toc">
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
                    <p class="legal-section__body">{!! $s['content'] !!}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<style>
.legal-layout { display:grid;grid-template-columns:220px 1fr;gap:48px;padding-top:56px; }
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
