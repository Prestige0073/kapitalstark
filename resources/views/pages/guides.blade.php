@extends('layouts.app')
@section('title', __('pages.titles.guides'))
@section('description', __('pages.guides.hero_sub'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:80px 60px;">
    <div class="container page-hero__inner">
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.guides.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('pages.guides.hero_title') }}</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;max-width:600px;margin-inline:auto;margin-top:12px;">
            {{ __('pages.guides.hero_sub') }}
        </p>
    </div>
</section>

<section style="background:var(--white);">
    <div class="container">

        {{-- Guide vedette --}}
        <div class="reveal" style="margin-bottom:60px;">
            <div class="card" style="display:grid;grid-template-columns:1fr 1fr;overflow:hidden;border-radius:24px;">
                <div style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding:48px;display:flex;flex-direction:column;justify-content:space-between;">
                    <div>
                        <span class="section-label" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">Guide complet</span>
                        <h2 style="color:#fff;font-size:28px;margin-top:14px;margin-bottom:16px;">Acheter votre résidence principale : le guide de A à Z</h2>
                        <p style="color:rgba(255,255,255,0.65);font-size:15px;line-height:1.7;">De la simulation jusqu'à la remise des clés : toutes les étapes, les documents nécessaires, les pièges à éviter et nos conseils d'experts pour réussir votre premier achat immobilier.</p>
                    </div>
                    <div style="margin-top:28px;display:flex;gap:16px;flex-wrap:wrap;">
                        <div style="font-size:13px;color:rgba(255,255,255,0.5);display:flex;align-items:center;gap:6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            15 min de lecture
                        </div>
                        <div style="font-size:13px;color:rgba(255,255,255,0.5);display:flex;align-items:center;gap:6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            12 étapes détaillées
                        </div>
                        <div style="font-size:13px;color:rgba(255,255,255,0.5);display:flex;align-items:center;gap:6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Mis à jour mars 2025
                        </div>
                    </div>
                </div>
                <div style="padding:48px;display:flex;flex-direction:column;gap:14px;">
                    <h3 style="font-size:16px;margin-bottom:8px;">Ce que vous apprendrez :</h3>
                    @foreach([
                        'Définir votre capacité d\'emprunt réelle',
                        'Trouver le bien idéal et négocier le prix',
                        'Constituer un dossier de prêt solide',
                        'Comparer les offres et négocier le taux',
                        'Choisir la meilleure assurance emprunteur',
                        'Comprendre l\'offre de prêt et les délais légaux',
                        'Les frais notariaux : calcul et optimisation',
                        'La signature chez le notaire : étape par étape',
                    ] as $step)
                    <div style="display:flex;align-items:flex-start;gap:10px;font-size:14px;color:var(--text-muted);">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2.5" style="flex-shrink:0;margin-top:2px;"><path d="M20 6L9 17l-5-5"/></svg>
                        {{ $step }}
                    </div>
                    @endforeach
                    <a href="{{ route('simulator.index') }}" class="btn btn-primary" style="margin-top:8px;justify-content:center;">
                        {{ __('pages.guides.cta_sim') }} →
                    </a>
                </div>
            </div>
        </div>

        {{-- Grille des guides --}}
        @php
        $guides = [
            [
                'icon'     => '🏠',
                'cat'      => 'Immobilier',
                'title'    => 'Prêt immobilier : tout comprendre avant de se lancer',
                'desc'     => 'TAEG, apport, durée, assurance… maîtrisez tous les concepts pour choisir le meilleur financement.',
                'read'     => '12 min',
                'steps'    => 8,
                'updated'  => 'Fév. 2025',
                'color'    => 'var(--blue)',
                'slug'     => 'pret-immobilier-guide-complet',
            ],
            [
                'icon'     => '🔑',
                'cat'      => 'Immobilier',
                'title'    => 'Investissement locatif : financer et rentabiliser',
                'desc'     => 'Dispositifs Pinel, LMNP, rendement locatif brut/net, fiscalité… notre guide de l\'investisseur.',
                'read'     => '14 min',
                'steps'    => 9,
                'updated'  => 'Jan. 2025',
                'color'    => 'var(--blue-dark)',
                'slug'     => 'investissement-locatif-guide',
            ],
            [
                'icon'     => '🚗',
                'cat'      => 'Automobile',
                'title'    => 'Financer son véhicule : LOA, LLD ou crédit auto ?',
                'desc'     => 'Comparatif complet des 3 formules, tableau de coût total, conseils selon votre profil.',
                'read'     => '9 min',
                'steps'    => 6,
                'updated'  => 'Mars 2025',
                'color'    => '#10b981',
                'slug'     => 'loa-vs-pret-auto',
            ],
            [
                'icon'     => '💼',
                'cat'      => 'Entreprise',
                'title'    => 'Financer la création de son entreprise en 2025',
                'desc'     => 'BPI, NACRE, love money, crowdfunding : combiner les sources de financement intelligemment.',
                'read'     => '11 min',
                'steps'    => 7,
                'updated'  => 'Fév. 2025',
                'color'    => '#f59e0b',
                'slug'     => 'pret-entreprise-creation',
            ],
            [
                'icon'     => '🔄',
                'cat'      => 'Optimisation',
                'title'    => 'Rachat de crédits : quand et comment en profiter',
                'desc'     => 'Regrouper vos crédits pour alléger vos mensualités. Calcul du gain, démarches, pièges.',
                'read'     => '8 min',
                'steps'    => 5,
                'updated'  => 'Jan. 2025',
                'color'    => 'var(--gold)',
                'slug'     => 'remboursement-anticipe-credit',
            ],
            [
                'icon'     => '⚖️',
                'cat'      => 'Assurance',
                'title'    => 'Assurance emprunteur : comparer et économiser',
                'desc'     => 'Délégation d\'assurance, loi Lemoine, garanties essentielles. Économisez jusqu\'à 50%.',
                'read'     => '7 min',
                'steps'    => 5,
                'updated'  => 'Mars 2025',
                'color'    => '#8b5cf6',
                'slug'     => 'assurance-emprunteur-deleguer',
            ],
            [
                'icon'     => '📊',
                'cat'      => 'Finance',
                'title'    => 'Optimiser son taux d\'endettement avant d\'emprunter',
                'desc'     => 'Stratégies concrètes pour améliorer votre dossier et maximiser votre capacité d\'emprunt.',
                'read'     => '6 min',
                'steps'    => 4,
                'updated'  => 'Fév. 2025',
                'color'    => 'var(--blue)',
                'slug'     => 'taux-endettement-guide-complet',
            ],
            [
                'icon'     => '🌾',
                'cat'      => 'Agricole',
                'title'    => 'Prêt agricole : financer son exploitation',
                'desc'     => 'Matériel, foncier, trésorerie saisonnière, aides PAC. Le guide complet pour les agriculteurs.',
                'read'     => '10 min',
                'steps'    => 6,
                'updated'  => 'Jan. 2025',
                'color'    => '#10b981',
                'slug'     => 'pret-agricole-guide',
            ],
            [
                'icon'     => '🌱',
                'cat'      => 'Inclusion',
                'title'    => 'Microcrédit : guide pour les exclus du système bancaire',
                'desc'     => 'Conditions, montants, organismes partenaires, démarches. Accédez au financement malgré les obstacles.',
                'read'     => '8 min',
                'steps'    => 5,
                'updated'  => 'Mars 2025',
                'color'    => '#f59e0b',
                'slug'     => 'microcredit-inclusion-financiere',
            ],
        ];
        $cats = array_values(array_unique(array_column($guides, 'cat')));
        @endphp

        {{-- Filtres --}}
        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:32px;" class="reveal" id="guide-filters">
            <button class="faq-cat active" data-cat="all">{{ __('pages.guides.filter_all') }}</button>
            @foreach($cats as $cat)
            <button class="faq-cat" data-cat="{{ $cat }}">{{ $cat }}</button>
            @endforeach
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;" id="guides-grid">
            @foreach($guides as $i => $guide)
            <div class="card guide-card reveal stagger-{{ ($i % 3) + 1 }}" data-cat="{{ $guide['cat'] }}">
                <div style="padding:28px 28px 0;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                        <div style="width:44px;height:44px;border-radius:12px;background:rgba(38,123,241,0.08);display:flex;align-items:center;justify-content:center;font-size:22px;">
                            {{ $guide['icon'] }}
                        </div>
                        <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:{{ $guide['color'] }};background:rgba(38,123,241,0.07);padding:4px 10px;border-radius:100px;">
                            {{ $guide['cat'] }}
                        </span>
                    </div>
                    <h3 style="font-size:17px;margin-bottom:10px;line-height:1.4;">{{ $guide['title'] }}</h3>
                    <p style="font-size:14px;color:var(--text-muted);line-height:1.65;margin-bottom:20px;">{{ $guide['desc'] }}</p>
                </div>
                <div style="padding:0 28px 20px;border-top:1px solid rgba(38,123,241,0.07);margin-top:auto;padding-top:16px;">
                    <div style="display:flex;gap:16px;font-size:12px;color:var(--text-muted);margin-bottom:16px;">
                        <span style="display:flex;align-items:center;gap:4px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $guide['read'] }}
                        </span>
                        <span style="display:flex;align-items:center;gap:4px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            {{ $guide['steps'] }} {{ __('pages.guides.steps_label') }}
                        </span>
                        <span style="display:flex;align-items:center;gap:4px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ $guide['updated'] }}
                        </span>
                    </div>
                    <a href="{{ route('blog.show', $guide['slug']) }}" class="btn btn-outline" style="width:100%;justify-content:center;font-size:13px;padding:10px;">
                        {{ __('pages.guides.read_guide') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- CTA --}}
<section class="cta-section" style="padding-block:80px;">
    <div class="container">
        <h2 class="section-title reveal" style="color:#fff;">{{ __('pages.guides.cta_title') }}</h2>
        <p class="section-desc reveal stagger-1" style="color:rgba(255,255,255,0.65);max-width:520px;margin-inline:auto;">
            {{ __('pages.guides.cta_sub') }}
        </p>
        <div class="cta-section__actions reveal stagger-2">
            <a href="{{ route('simulator.index') }}" class="btn btn-primary" style="font-size:17px;padding:16px 36px;">{{ __('pages.guides.cta_sim') }}</a>
            <a href="{{ route('contact.rdv') }}" class="btn" style="background:rgba(255,255,255,0.1);color:#fff;border:1px solid rgba(255,255,255,0.2);font-size:17px;padding:16px 36px;">{{ __('pages.guides.cta_rdv') }}</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
(function () {
    'use strict';
    var btns  = document.querySelectorAll('#guide-filters .faq-cat');
    var cards = document.querySelectorAll('#guides-grid .guide-card');

    btns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            btns.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var cat = btn.getAttribute('data-cat');
            cards.forEach(function (card) {
                card.style.display = (cat === 'all' || card.getAttribute('data-cat') === cat) ? '' : 'none';
            });
        });
    });
})();
</script>
@endsection
