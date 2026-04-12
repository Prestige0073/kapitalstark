@extends('layouts.app')
@section('title', __('pages.titles.privacy'))
@section('description', 'Politique de confidentialité RGPD de KapitalStark : données collectées, finalités, durées de conservation, vos droits.')
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:60px 40px;">
    <div class="container page-hero__inner">
        <nav style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:12px;">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5);">Accueil</a>
            <span style="margin-inline:8px;">›</span>
            <span>Confidentialité</span>
        </nav>
        <h1 style="color:#fff;">Politique de Confidentialité</h1>
        <p style="color:rgba(255,255,255,0.55);margin-top:8px;font-size:14px;">Dernière mise à jour : {{ date('d/m/Y') }} — Conforme RGPD (UE) 2016/679</p>
    </div>
</section>

@php
$sections = [
    ['id'=>'responsable',   'title'=>'1. Responsable du traitement',   'content'=>'<strong>KapitalStark, S.A.</strong><br>Avenida da Liberdade, 110, 3.º andar, 1269-046 Lisboa, Portugal<br>NIF/NIPC : 506 789 123<br><br><strong>Délégué à la Protection des Données (DPO) :</strong><br>Nom : Ana Rodrigues<br>Email : <a href="mailto:dpo@kapitalstark.pt" style="color:var(--blue);">dpo@kapitalstark.pt</a><br>Adresse : KapitalStark, S.A. — DPO, Av. da Liberdade, 110, 3.º andar, 1269-046 Lisboa'],
    ['id'=>'collecte',      'title'=>'2. Données collectées',          'content'=>'Nous collectons les catégories de données suivantes :<br><br><strong>Données d\'identification :</strong> nom, prénom, date de naissance, pièce d\'identité, adresse email, numéro de téléphone, adresse postale.<br><br><strong>Données financières :</strong> revenus, charges, montant et type de prêt souhaité, taux d\'endettement, historique bancaire — uniquement dans le cadre de l\'étude de votre dossier de prêt.<br><br><strong>Données de connexion :</strong> adresse IP, logs de connexion à l\'espace client, données de navigation (avec consentement).<br><br><strong>Données de communication :</strong> messages échangés avec nos conseillers, enregistrements téléphoniques (avec information préalable).'],
    ['id'=>'finalites',     'title'=>'3. Finalités du traitement',     'content'=>'Vos données sont traitées pour les finalités suivantes :<br><br>• <strong>Exécution du contrat :</strong> étude de vos demandes de financement, gestion de vos prêts, suivi de votre espace client.<br>• <strong>Obligation légale :</strong> conformité BCFT (Branqueamento de Capitais e Financiamento do Terrorismo), KYC (Know Your Customer), reporting réglementaire Banco de Portugal, obligations issues du DL 133/2009 et du DL 74-A/2017.<br>• <strong>Consentement :</strong> newsletter, cookies analytiques et marketing, communications commerciales personnalisées.<br>• <strong>Intérêt légitime :</strong> amélioration de nos services, prévention des fraudes, sécurité informatique, analyse statistique anonymisée.'],
    ['id'=>'base-legale',   'title'=>'4. Base légale',                 'content'=>'<table style="width:100%;font-size:14px;border-collapse:collapse;"><thead><tr style="background:rgba(38,123,241,0.06);"><th style="padding:10px 14px;text-align:left;font-weight:700;color:var(--text);border-bottom:2px solid rgba(38,123,241,0.1);">Finalité</th><th style="padding:10px 14px;text-align:left;font-weight:700;color:var(--text);border-bottom:2px solid rgba(38,123,241,0.1);">Base légale</th></tr></thead><tbody><tr><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">Gestion des prêts</td><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">Exécution d\'un contrat</td></tr><tr><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">LCB-FT / KYC</td><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">Obligation légale</td></tr><tr><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">Newsletter &amp; Marketing</td><td style="padding:10px 14px;border-bottom:1px solid rgba(38,123,241,0.06);color:var(--text-muted);">Consentement</td></tr><tr><td style="padding:10px 14px;color:var(--text-muted);">Amélioration du service</td><td style="padding:10px 14px;color:var(--text-muted);">Intérêt légitime</td></tr></tbody></table>'],
    ['id'=>'conservation',  'title'=>'5. Durées de conservation',      'content'=>'<strong>Clients actifs :</strong> durée de la relation commerciale + 5 ans après la fin du contrat.<br><br><strong>Prospects :</strong> 3 ans à compter du dernier contact ou du dernier consentement.<br><br><strong>Données KYC :</strong> 7 ans après la fin de la relation d\'affaires, conformément à l\'article 51.º de la Lei n.º 83/2017 (BCFT).<br><br><strong>Logs de connexion :</strong> 12 mois conformément aux obligations légales portugaises.<br><br><strong>Cookies analytiques :</strong> 13 mois maximum.'],
    ['id'=>'destinataires', 'title'=>'6. Destinataires des données',   'content'=>'Vos données peuvent être partagées avec :<br><br>• <strong>Nos prestataires techniques</strong> (hébergeur, éditeur CRM) — liés par des contrats de sous-traitance RGPD.<br>• <strong>Nos partenaires bancaires et assureurs</strong> — dans le cadre de l\'instruction de votre dossier, avec votre consentement préalable.<br>• <strong>Les autorités compétentes</strong> — Banco de Portugal, UIF (Unidade de Informação Financeira), autorités judiciaires — en cas d\'obligation légale.<br><br>Aucune donnée n\'est vendue à des tiers à des fins commerciales.'],
    ['id'=>'transferts',    'title'=>'7. Transferts hors UE',          'content'=>'KapitalStark SAS s\'engage à ne procéder à aucun transfert de données à caractère personnel en dehors de l\'Union Européenne. L\'ensemble de nos prestataires est localisé dans l\'Espace Économique Européen. Si un transfert devait être envisagé, nous veillerions à ce que les garanties appropriées soient mises en place (clauses contractuelles types de la Commission Européenne, décision d\'adéquation).'],
    ['id'=>'droits',        'title'=>'8. Vos droits',                  'content'=>'Conformément au RGPD, vous disposez des droits suivants :<br><br>• <strong>Droit d\'accès</strong> (Art. 15) : obtenir une copie de vos données.<br>• <strong>Droit de rectification</strong> (Art. 16) : corriger des données inexactes ou incomplètes.<br>• <strong>Droit à l\'effacement</strong> (Art. 17) : obtenir la suppression de vos données dans les cas prévus par la loi.<br>• <strong>Droit à la limitation</strong> (Art. 18) : limiter le traitement dans certains cas.<br>• <strong>Droit à la portabilité</strong> (Art. 20) : recevoir vos données dans un format structuré et lisible par machine.<br>• <strong>Droit d\'opposition</strong> (Art. 21) : vous opposer au traitement fondé sur l\'intérêt légitime.<br><br>Pour exercer vos droits : <a href="mailto:dpo@kapitalstark.pt" style="color:var(--blue);">dpo@kapitalstark.pt</a> ou via votre espace client (rubrique Mon Profil). Vous pouvez également introduire une réclamation auprès de la <a href="https://www.cnpd.pt" style="color:var(--blue);" target="_blank" rel="noopener">CNPD (Comissão Nacional de Proteção de Dados)</a>.'],
    ['id'=>'securite',      'title'=>'9. Sécurité',                    'content'=>'KapitalStark met en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données contre tout accès non autorisé, perte, destruction ou divulgation :<br><br>• Chiffrement TLS 1.3 de toutes les communications<br>• Chiffrement AES-256 des données sensibles en base<br>• Authentification multi-facteurs pour les accès internes<br>• Contrôle d\'accès basé sur les rôles (RBAC)<br>• Audits de sécurité et tests d\'intrusion semestriels<br>• Certification ISO 27001 en cours'],
    ['id'=>'modification',  'title'=>'10. Modification de la politique','content'=>'KapitalStark SAS se réserve le droit de modifier la présente politique à tout moment pour refléter les évolutions légales, réglementaires ou pratiques. En cas de modification substantielle, vous serez informé(e) par email ou par un avis visible sur notre Site, avec un préavis de 30 jours lorsque cela est possible.'],
];
@endphp

<section style="background:var(--white);padding-block:0 80px;">
    <div class="container" style="max-width:1080px;">
        <div class="legal-layout">
            <aside class="legal-toc">
                <div class="legal-toc__inner">
                    <p class="legal-toc__title">Sommaire</p>
                    <nav>
                        @foreach($sections as $s)
                        <a class="legal-toc__link" href="#{{ $s['id'] }}">{{ $s['title'] }}</a>
                        @endforeach
                    </nav>
                    <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(38,123,241,0.1);">
                        <p style="font-size:11px;color:var(--text-muted);line-height:1.6;">
                            Pour toute question :<br>
                            <a href="mailto:dpo@kapitalstark.pt" style="color:var(--blue);font-weight:600;">dpo@kapitalstark.pt</a>
                        </p>
                    </div>
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
.legal-section__body strong { color:var(--text); }
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
