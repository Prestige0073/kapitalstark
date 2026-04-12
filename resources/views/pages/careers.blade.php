@extends('layouts.app')
@section('title', __('pages.titles.careers'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:80px 60px;">
    <div class="container page-hero__inner">
        <nav style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:16px;">
            <a href="{{ route('about') }}" style="color:rgba(255,255,255,0.5);text-decoration:none;">{{ __('pages.careers.breadcrumb_about') }}</a>
            <span style="margin-inline:8px;">›</span>
            <span style="color:rgba(255,255,255,0.85);">{{ __('pages.careers.breadcrumb_cur') }}</span>
        </nav>
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.careers.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('pages.careers.hero_title') }}</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;margin-top:12px;max-width:640px;margin-inline:auto;">
            {{ __('pages.careers.hero_sub') }}
        </p>
    </div>
</section>

{{-- Pourquoi nous rejoindre --}}
<section style="background:var(--cream);">
    <div class="container">
        <div class="section-header">
            <span class="section-label reveal">{{ __('pages.careers.perks_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('pages.careers.perks_title') }}</h2>
        </div>
        <div class="values-grid reveal">
            @foreach(trans('pages.careers.perks') as $v)
            <div class="card value-card reveal">
                <div style="font-size:32px;margin-bottom:14px;">{{ $v['icon'] }}</div>
                <h3 style="font-size:17px;margin-bottom:8px;">{{ $v['title'] }}</h3>
                <p style="font-size:14px;color:var(--text-muted);line-height:1.65;">{{ $v['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Offres d'emploi --}}
<section style="background:var(--white);">
    <div class="container" style="max-width:900px;">
        <div class="section-header">
            <span class="section-label reveal">{{ __('pages.careers.jobs_label') }}</span>
            <h2 class="section-title reveal stagger-1">{{ __('pages.careers.jobs_title') }}</h2>
            <p class="section-desc reveal stagger-2">{{ date('F Y') }} — 6 {{ __('pages.careers.jobs_label') }}</p>
        </div>

        <div class="jobs-list reveal">

            @php
            $jobs = [
                [
                    'icon'    => '💼',
                    'title'   => 'Conseiller(ère) en financement immobilier',
                    'tags'    => [['CDI','type'],['Lisboa','location'],['Exp. 3+ ans',''],],
                    'desc'    => 'Vous accompagnez nos clients particuliers dans leurs projets d\'acquisition immobilière, de la simulation jusqu\'à la signature de l\'offre de prêt.',
                    'missions'=> ['Analyser les dossiers de financement et proposer des solutions adaptées','Développer et fidéliser un portefeuille clients','Collaborer avec nos partenaires notaires et agences immobilières','Veiller au respect des normes réglementaires (Mediador de Crédito)'],
                    'profile' => 'Titulaire d\'une Licenciatura minimum en banque/finance ou immobilier. Expérience de 3 ans minimum en crédito habitação.',
                ],
                [
                    'icon'    => '🖥️',
                    'title'   => 'Développeur(euse) Full Stack Laravel / Vue.js',
                    'tags'    => [['CDI','type'],['Lisboa ou Remote','location'],['Exp. 4+ ans',''],],
                    'desc'    => 'Vous participez au développement et à l\'évolution de notre plateforme propriétaire de gestion des crédits et de l\'espace client.',
                    'missions'=> ['Développer de nouvelles fonctionnalités sur notre stack Laravel + Vue.js','Participer aux revues de code et à l\'amélioration de l\'architecture','Écrire des tests automatisés (PHPUnit, Vitest)','Collaborer avec l\'équipe produit dans un contexte Agile'],
                    'profile' => 'Maîtrise de Laravel 10+ et Vue.js 3. Bonne connaissance de MySQL, Redis, et des pratiques CI/CD.',
                ],
                [
                    'icon'    => '⚖️',
                    'title'   => 'Analyste Risques & Conformité',
                    'tags'    => [['CDI','type'],['Lisboa','location'],['Exp. 2+ ans',''],],
                    'desc'    => 'Vous contribuez à la maîtrise des risques de crédit et au respect du cadre réglementaire bancaire (Banco de Portugal, BCFT, RGPD).',
                    'missions'=> ['Analyser la qualité du portefeuille de crédits','Mettre à jour les procédures de conformité','Assurer la veille réglementaire Banco de Portugal et EBA','Préparer les reportings réglementaires'],
                    'profile' => 'Formation Bac+5 en droit bancaire, finance ou mathématiques. Connaissance des normes Bâle III/IV.',
                ],
                [
                    'icon'    => '📣',
                    'title'   => 'Chargé(e) de Marketing Digital',
                    'tags'    => [['CDI','type'],['Lisboa','location'],['Exp. 2+ ans',''],],
                    'desc'    => 'Vous gérez la présence digitale de KapitalStark et pilotez les campagnes d\'acquisition en ligne.',
                    'missions'=> ['Gérer et optimiser les campagnes SEA (Google Ads) et paid social','Produire du contenu pour le blog et les réseaux sociaux','Analyser les KPIs et optimiser le tunnel de conversion','Coordonner avec l\'équipe tech pour les évolutions du site'],
                    'profile' => 'Maîtrise de Google Analytics 4, Meta Ads, et SEO. Expérience en B2C ou fintech.',
                ],
                [
                    'icon'    => '🏢',
                    'title'   => 'Conseiller(ère) Financement Entreprises',
                    'tags'    => [['CDI','type'],['Porto ou Lisboa','location'],['Exp. 5+ ans',''],],
                    'desc'    => 'Vous développez notre activité de financement aux PME et ETI, en gérant un portefeuille de clients professionnels.',
                    'missions'=> ['Détecter et qualifier les opportunités de financement professionnels','Structurer des solutions de financement complexes','Suivre les dossiers jusqu\'au déblocage des fonds','Entretenir les relations avec les experts-comptables partenaires'],
                    'profile' => 'Expérience confirmée en banque d\'affaires ou crédit aux entreprises. Maîtrise de l\'analyse financière d\'entreprise.',
                ],
                [
                    'icon'    => '🎓',
                    'title'   => 'Stage — Assistant(e) Communication',
                    'tags'    => [['Estágio 6 meses','type'],['Lisboa','location'],['Licenciatura/Mestrado',''],],
                    'desc'    => 'Vous assistez la directrice communication dans la production de contenus et la gestion des relations presse.',
                    'missions'=> ['Rédiger des articles de blog et contenus réseaux sociaux','Assister à la préparation des dossiers de presse','Participer à l\'organisation des événements internes et externes','Veille concurrentielle et sectorielle'],
                    'profile' => 'Étudiant(e) en communication, journalisme ou marketing. Excellente plume en français.',
                ],
            ];
            @endphp

            @foreach($jobs as $i => $job)
            <div class="job-item" id="job-{{ $i }}">
                <div class="job-item__header" onclick="toggleJob('{{ $i }}')" role="button" aria-expanded="false" aria-controls="job-body-{{ $i }}">
                    <div class="job-item__icon">{{ $job['icon'] }}</div>
                    <div class="job-item__meta">
                        <p class="job-item__title">{{ $job['title'] }}</p>
                        <div class="job-item__tags">
                            @foreach($job['tags'] as $tag)
                            <span class="job-tag {{ $tag[1] === 'location' ? 'job-tag--location' : ($tag[1] === 'type' ? 'job-tag--type' : '') }}">
                                {{ $tag[0] }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    <svg class="job-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </div>
                <div class="job-item__body" id="job-body-{{ $i }}">
                    <div class="job-item__content">
                        <p style="font-size:15px;color:var(--text-muted);line-height:1.75;margin-bottom:20px;">{{ $job['desc'] }}</p>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:28px;">
                            <div>
                                <h4 style="font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:12px;">{{ __('pages.careers.job_missions') }}</h4>
                                <ul style="display:flex;flex-direction:column;gap:8px;">
                                    @foreach($job['missions'] as $m)
                                    <li style="display:flex;gap:10px;font-size:14px;color:var(--text-muted);line-height:1.55;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.5" style="flex-shrink:0;margin-top:3px;" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg>
                                        {{ $m }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div>
                                <h4 style="font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:12px;">{{ __('pages.careers.job_profile') }}</h4>
                                <p style="font-size:14px;color:var(--text-muted);line-height:1.65;">{{ $job['profile'] }}</p>
                                <a href="{{ route('contact') }}" class="btn btn-primary" style="margin-top:20px;padding:12px 24px;font-size:14px;">
                                    {{ __('pages.careers.job_apply') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        {{-- Candidature spontanée --}}
        <div class="card reveal" style="padding:36px;margin-top:32px;display:flex;align-items:center;gap:28px;flex-wrap:wrap;">
            <div style="font-size:40px;">📬</div>
            <div style="flex:1;min-width:200px;">
                <h3 style="font-size:18px;margin-bottom:6px;">{{ __('pages.careers.spont_title') }}</h3>
                <p style="font-size:14px;color:var(--text-muted);">{{ __('pages.careers.spont_desc') }}</p>
            </div>
            <a href="{{ route('contact') }}" class="btn btn-outline" style="flex-shrink:0;">{{ __('pages.careers.spont_btn') }}</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
function toggleJob(id) {
    var item = document.getElementById('job-' + id);
    var body = document.getElementById('job-body-' + id);
    var header = item.querySelector('.job-item__header');
    var isOpen = item.classList.toggle('open');
    header.setAttribute('aria-expanded', String(isOpen));
}
</script>
@endsection
