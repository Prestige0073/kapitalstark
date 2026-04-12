@extends('layouts.app')
@section('title', __('pages.titles.legal'))
@section('description', 'Informação legal de KapitalStark, S.A. — editor, alojamento, propriedade intelectual, actividade regulada pelo Banco de Portugal.')
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:60px 40px;">
    <div class="container page-hero__inner">
        <nav style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:12px;">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5);">Accueil</a>
            <span style="margin-inline:8px;">›</span>
            <span>Informação Legal</span>
        </nav>
        <h1 style="color:#fff;">Informação Legal</h1>
        <p style="color:rgba(255,255,255,0.55);margin-top:8px;font-size:14px;">Última atualização : {{ date('d/m/Y') }}</p>
    </div>
</section>

@php
$sections = [
    ['id'=>'editeur',       'title'=>'1. Éditeur du site',          'content'=>'Le site <strong>kapitalstark.pt</strong> est édité par <strong>KapitalStark, S.A.</strong>, société anonyme au capital de 2 000 000 €, immatriculée à la Conservatória do Registo Comercial de Lisboa sous le numéro 28745, NIF/NIPC : <strong>506 789 123</strong>, dont le siège social est situé Avenida da Liberdade, 110, 3.º andar, 1269-046 Lisboa, Portugal. Enregistrée auprès du <strong>Banco de Portugal</strong> en tant qu\'institution de crédit sous le N° 4567. Numéro IVA : PT 506 789 123.'],
    ['id'=>'direction',     'title'=>'2. Directeur de la publication','content'=>'M. João Ferreira, Président Directeur Général de KapitalStark, S.A. Contact : <a href="mailto:direcao@kapitalstark.pt" style="color:var(--blue);">direcao@kapitalstark.pt</a>'],
    ['id'=>'hebergement',   'title'=>'3. Hébergement',               'content'=>'Le site kapitalstark.pt est hébergé par <strong>OVHcloud</strong>, SAS au capital de 10 174 560 €, immatriculée au RCS de Lille Métropole sous le numéro 424 761 419 00045, dont le siège social est situé 2 Rue Kellermann, 59100 Roubaix, France. Téléphone : +33 9 72 10 10 07.'],
    ['id'=>'activite',      'title'=>'4. Activité réglementée',      'content'=>'KapitalStark, S.A. est une institution de crédit agréée par le <strong>Banco de Portugal</strong>, Rua do Ouro, 27, 1100-150 Lisboa. Cet agrément est consultable sur le site officiel du Banco de Portugal (www.bportugal.pt). KapitalStark est soumis à la réglementation bancaire portugaise et européenne, notamment les directives CRD IV/CRR, le DL 133/2009 (crédit à la consommation), le DL 74-A/2017 (crédit hypothécaire) et la réglementation BCFT (Branqueamento de Capitais e Financiamento do Terrorismo).'],
    ['id'=>'pi',            'title'=>'5. Propriété intellectuelle',  'content'=>'L\'ensemble des contenus présents sur ce site (textes, images, vidéos, logo, icônes, logiciels) est la propriété exclusive de KapitalStark, S.A. ou de ses partenaires, et est protégé par les lois portugaises et internationales relatives à la propriété intellectuelle (Código do Direito de Autor e dos Direitos Conexos). Toute reproduction, représentation, modification, publication, adaptation ou exploitation, intégrale ou partielle, de ces éléments est formellement interdite sans autorisation préalable écrite de KapitalStark, S.A.'],
    ['id'=>'responsabilite','title'=>'6. Limitation de responsabilité','content'=>'Les informations et taux présentés sur ce site sont fournis à titre indicatif et sont susceptibles d\'évoluer sans préavis. Ils ne constituent pas une offre contractuelle de crédit. KapitalStark, S.A. s\'efforce d\'assurer l\'exactitude et la mise à jour des informations diffusées sur ce site, mais ne saurait être tenu responsable d\'éventuelles erreurs, omissions ou inexactitudes. L\'utilisation des informations disponibles sur ce site est effectuée sous la seule et entière responsabilité de l\'utilisateur.'],
    ['id'=>'donnees',       'title'=>'7. Données personnelles',      'content'=>'Conformément au Règlement Général sur la Protection des Données (RGPD — Regulamento (UE) 2016/679) et à la Lei n.º 58/2019 de droit portugais, vous disposez d\'un droit d\'accès, de rectification, d\'effacement et de portabilité de vos données. Pour exercer ces droits, contactez notre DPO : <a href="mailto:dpo@kapitalstark.pt" style="color:var(--blue);">dpo@kapitalstark.pt</a>. Consultez notre <a href="' . route('privacy') . '" style="color:var(--blue);">Politique de Confidentialité</a> pour plus d\'informations.'],
    ['id'=>'cookies',       'title'=>'8. Cookies',                   'content'=>'Le site utilise des cookies techniques nécessaires à son fonctionnement et, avec votre consentement, des cookies analytiques permettant de mesurer l\'audience. Vous pouvez gérer vos préférences via le bandeau de consentement ou dans les paramètres de votre navigateur. Conformément aux recommandations de la CNPD (Comissão Nacional de Proteção de Dados).'],
    ['id'=>'contact',       'title'=>'9. Contact',                   'content'=>'Pour toute question relative à cette information légale : <a href="mailto:juridico@kapitalstark.pt" style="color:var(--blue);">juridico@kapitalstark.pt</a> — KapitalStark, S.A., Avenida da Liberdade, 110, 3.º andar, 1269-046 Lisboa — Tél. +351 21 000 12 34.'],
];
@endphp

<section style="background:var(--white);padding-block:0 80px;">
    <div class="container" style="max-width:1080px;">
        <div class="legal-layout">

            {{-- TOC sticky --}}
            <aside class="legal-toc" id="legal-toc">
                <div class="legal-toc__inner">
                    <p class="legal-toc__title">Sommaire</p>
                    <nav>
                        @foreach($sections as $s)
                        <a class="legal-toc__link" href="#{{ $s['id'] }}" id="toc-{{ $s['id'] }}">{{ $s['title'] }}</a>
                        @endforeach
                    </nav>
                </div>
            </aside>

            {{-- Contenu --}}
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
.legal-layout {
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 48px;
    padding-top: 56px;
}
.legal-toc__inner {
    position: sticky;
    top: 100px;
    background: rgba(38,123,241,0.03);
    border: 1px solid rgba(38,123,241,0.1);
    border-radius: var(--radius-lg);
    padding: 24px;
}
.legal-toc__title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--text-muted);
    margin-bottom: 14px;
}
.legal-toc__link {
    display: block;
    font-size: 13px;
    color: var(--text-muted);
    padding: 7px 10px;
    border-radius: 8px;
    transition: all 0.2s;
    margin-bottom: 2px;
    border-left: 2px solid transparent;
    text-decoration: none;
    line-height: 1.4;
}
.legal-toc__link:hover { color: var(--blue); background: rgba(38,123,241,0.05); }
.legal-toc__link.active { color: var(--blue); background: rgba(38,123,241,0.08); border-left-color: var(--blue); font-weight: 600; }

.legal-content { min-width: 0; }
.legal-section {
    padding-block: 36px;
    border-bottom: 1px solid rgba(38,123,241,0.07);
    scroll-margin-top: 110px;
}
.legal-section:last-child { border-bottom: none; }
.legal-section__title {
    font-size: 19px;
    font-family: var(--font-sans);
    font-weight: 700;
    color: var(--text);
    margin-bottom: 14px;
}
.legal-section__body {
    font-size: 15px;
    color: var(--text-muted);
    line-height: 1.8;
}

@media (max-width: 1024px) {
    .legal-layout { grid-template-columns: 1fr; gap: 0; }
    .legal-toc    { display: none; }
}
</style>
<script>
(function () {
    'use strict';
    var links = document.querySelectorAll('.legal-toc__link');
    var ids   = Array.from(links).map(function (l) { return l.getAttribute('href').slice(1); });

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                links.forEach(function (l) { l.classList.remove('active'); });
                var active = document.querySelector('.legal-toc__link[href="#' + e.target.id + '"]');
                if (active) active.classList.add('active');
            }
        });
    }, { rootMargin: '-20% 0px -70% 0px' });

    ids.forEach(function (id) {
        var el = document.getElementById(id);
        if (el) observer.observe(el);
    });

    links.forEach(function (l) {
        l.addEventListener('click', function (e) {
            e.preventDefault();
            var id = l.getAttribute('href').slice(1);
            var el = document.getElementById(id);
            if (el) el.scrollIntoView({ behavior: 'smooth' });
        });
    });
})();
</script>
@endsection
