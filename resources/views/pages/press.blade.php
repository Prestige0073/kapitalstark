@extends('layouts.app')
@section('title', __('pages.titles.press'))
@section('description', 'Espace presse KapitalStark : communiqués de presse, chiffres clés, kit média, contacts journalistes.')
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:80px 60px;">
    <div class="container page-hero__inner">
        <nav style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:12px;">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5);">Accueil</a>
            <span style="margin-inline:8px;">›</span>
            <span>Espace Presse</span>
        </nav>
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">Journalistes &amp; Médias</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">Espace Presse</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;max-width:600px;margin-inline:auto;margin-top:12px;">
            Retrouvez nos communiqués, chiffres clés et ressources médias. Notre équipe presse répond sous 4h ouvrées.
        </p>
        <div class="reveal stagger-3" style="margin-top:28px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="mailto:presse@kapitalstark.fr" class="btn btn-primary" style="font-size:15px;padding:12px 28px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Contacter l'équipe presse
            </a>
            <a href="#kit-media" class="btn" style="background:rgba(255,255,255,0.12);color:#fff;border:1px solid rgba(255,255,255,0.2);font-size:15px;padding:12px 28px;">
                Télécharger le kit média
            </a>
        </div>
    </div>
</section>

<section style="background:var(--white);">
    <div class="container">

        {{-- Chiffres clés médias --}}
        <div class="reveal" style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:72px;">
            @foreach([
                ['val'=>'2010','label'=>'Année de création','icon'=>'🏛'],
                ['val'=>'+50 000','label'=>'Clients actifs','icon'=>'👥'],
                ['val'=>'5','label'=>'Agences en France','icon'=>'📍'],
                ['val'=>'2 Md€','label'=>'Financements accordés','icon'=>'💰'],
            ] as $k)
            <div class="card" style="padding:28px;text-align:center;">
                <div style="font-size:32px;margin-bottom:10px;">{{ $k['icon'] }}</div>
                <div class="font-mono" style="font-size:28px;font-weight:700;color:var(--blue);margin-bottom:6px;">{{ $k['val'] }}</div>
                <p style="font-size:13px;color:var(--text-muted);">{{ $k['label'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Derniers communiqués --}}
        <div class="section-header reveal" style="margin-bottom:40px;">
            <span class="section-label">Actualités</span>
            <h2 class="section-title">Derniers communiqués de presse</h2>
        </div>

        <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:72px;">
            @php
            $releases = [
                ['date'=>'15 mars 2025','cat'=>'Résultats','title'=>'KapitalStark publie ses résultats annuels 2024 : +23% de financements accordés','excerpt'=>'KapitalStark annonce une croissance de 23% de son volume de financements en 2024, portant le total à 2 milliards d\'euros. Le prêt immobilier reste le moteur avec 68% des dossiers.','tag'=>'Financier'],
                ['date'=>'8 fév. 2025', 'cat'=>'Partenariat','title'=>'Nouveau partenariat avec BPI France pour le financement des TPE/PME','excerpt'=>'KapitalStark et BPI France annoncent un accord de co-financement permettant d\'accélérer l\'accès au crédit pour les très petites et petites entreprises françaises.','tag'=>'Entreprise'],
                ['date'=>'22 jan. 2025','cat'=>'Innovation','title'=>'Lancement de l\'outil de capacité d\'emprunt instantanée','excerpt'=>'KapitalStark dévoile son nouveau calculateur de capacité d\'emprunt basé sur l\'intelligence artificielle, permettant une réponse de principe en moins de 3 minutes.','tag'=>'Technologie'],
                ['date'=>'10 déc. 2024','cat'=>'RSE','title'=>'KapitalStark obtient le label Financement Responsable de l\'ASF','excerpt'=>'Après 18 mois d\'audit, KapitalStark reçoit le label Financement Responsable décerné par l\'Association des Sociétés Financières, reconnaissant ses pratiques exemplaires en matière d\'octroi de crédit.','tag'=>'RSE'],
                ['date'=>'5 nov. 2024', 'cat'=>'Expansion','title'=>'Ouverture de la 5e agence KapitalStark à Bordeaux','excerpt'=>'KapitalStark inaugure sa 5e agence physique à Bordeaux, renforçant son ancrage régional dans le Grand Sud-Ouest avec une équipe de 8 conseillers spécialisés.','tag'=>'Développement'],
            ];
            $tagColors = ['Financier'=>'var(--blue)','Entreprise'=>'var(--gold)','Technologie'=>'#10b981','RSE'=>'#22c55e','Développement'=>'#8b5cf6'];
            @endphp
            @foreach($releases as $i => $rel)
            <div class="card reveal" style="padding:28px;display:flex;gap:24px;align-items:flex-start;">
                <div style="min-width:90px;text-align:center;flex-shrink:0;">
                    <div style="font-size:11px;text-transform:uppercase;letter-spacing:0.06em;font-weight:700;color:var(--text-muted);">{{ explode(' ', $rel['date'])[1] ?? '' }} {{ explode(' ', $rel['date'])[2] ?? '' }}</div>
                    <div class="font-mono" style="font-size:26px;font-weight:700;color:var(--text);">{{ explode(' ', $rel['date'])[0] }}</div>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                        <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:{{ $tagColors[$rel['tag']] ?? 'var(--blue)' }};background:rgba(38,123,241,0.07);padding:3px 10px;border-radius:100px;">{{ $rel['tag'] }}</span>
                    </div>
                    <h3 style="font-size:17px;margin-bottom:8px;line-height:1.4;">{{ $rel['title'] }}</h3>
                    <p style="font-size:14px;color:var(--text-muted);line-height:1.65;">{{ $rel['excerpt'] }}</p>
                </div>
                <a href="mailto:presse@kapitalstark.fr" class="btn btn-outline btn--sm" style="flex-shrink:0;white-space:nowrap;">
                    Demander le CP
                </a>
            </div>
            @endforeach
        </div>

        {{-- Kit média --}}
        <div id="kit-media" class="reveal" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));border-radius:24px;padding:56px;margin-bottom:72px;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center;">
                <div>
                    <span class="section-label" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">Ressources médias</span>
                    <h2 style="color:#fff;margin-top:14px;margin-bottom:16px;">Kit média KapitalStark</h2>
                    <p style="color:rgba(255,255,255,0.65);font-size:15px;line-height:1.75;margin-bottom:28px;">Téléchargez nos ressources officielles : logo en haute définition, charte graphique, photos d'équipe, présentation institutionnelle et infographies.</p>
                    <a href="mailto:presse@kapitalstark.fr" class="btn btn-primary" style="font-size:15px;padding:13px 28px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Demander le kit complet
                    </a>
                </div>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach([
                        ['icon'=>'🎨','label'=>'Logo vectoriel (SVG + PNG)','size'=>'2.4 Mo'],
                        ['icon'=>'📐','label'=>'Charte graphique complète','size'=>'8.1 Mo'],
                        ['icon'=>'📸','label'=>'Photos équipe & agences','size'=>'34 Mo'],
                        ['icon'=>'📊','label'=>'Présentation institutionnelle','size'=>'4.7 Mo'],
                        ['icon'=>'📋','label'=>'Biographies dirigeants','size'=>'340 Ko'],
                    ] as $asset)
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;background:rgba(255,255,255,0.07);border-radius:12px;padding:14px 18px;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <span style="font-size:20px;">{{ $asset['icon'] }}</span>
                            <span style="font-size:14px;color:rgba(255,255,255,0.85);font-weight:600;">{{ $asset['label'] }}</span>
                        </div>
                        <span style="font-size:11px;color:rgba(255,255,255,0.4);">{{ $asset['size'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Contact presse --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:32px;margin-bottom:80px;">
            <div class="card reveal" style="padding:36px;">
                <div style="font-size:40px;margin-bottom:16px;">📞</div>
                <h3 style="font-size:19px;margin-bottom:8px;">Relations Presse</h3>
                <p style="font-size:14px;color:var(--text-muted);margin-bottom:20px;line-height:1.65;">Notre responsable communication est disponible pour interviews, demandes d'informations et prises de parole.</p>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <p style="font-size:14px;color:var(--text);font-weight:600;">Marie Dubois</p>
                    <p style="font-size:13px;color:var(--text-muted);">Directrice Communication</p>
                    <a href="mailto:presse@kapitalstark.fr" style="font-size:14px;color:var(--blue);font-weight:600;">presse@kapitalstark.fr</a>
                    <a href="tel:+33142000002" style="font-size:14px;color:var(--blue);">+33 1 42 00 00 02</a>
                    <p style="font-size:12px;color:var(--text-muted);margin-top:4px;">Disponible Lun–Ven 9h–18h · Réponse sous 4h</p>
                </div>
            </div>
            <div class="card reveal stagger-1" style="padding:36px;">
                <div style="font-size:40px;margin-bottom:16px;">📰</div>
                <h3 style="font-size:19px;margin-bottom:8px;">Accréditation journaliste</h3>
                <p style="font-size:14px;color:var(--text-muted);margin-bottom:20px;line-height:1.65;">Pour accéder aux événements KapitalStark, obtenir une interview de direction ou des commentaires sur l'actualité financière.</p>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach(['Accès privilégié aux événements KapitalStark','Commentaires d\'experts sous 2h','Données exclusives et études de marché','Visite d\'agence avec nos conseillers'] as $item)
                    <div style="display:flex;align-items:center;gap:8px;font-size:14px;color:var(--text-muted);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                        {{ $item }}
                    </div>
                    @endforeach
                    <a href="mailto:presse@kapitalstark.fr?subject=Demande accréditation" class="btn btn-outline" style="margin-top:12px;width:fit-content;">Demander une accréditation</a>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
