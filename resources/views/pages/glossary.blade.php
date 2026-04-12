@extends('layouts.app')
@section('title', __('pages.titles.glossary'))
@section('description', __('pages.glossary.hero_sub'))
@section('styles')<link rel="stylesheet" href="{{ asset('css/pages.css') }}">@endsection

@section('content')

<section class="page-hero" style="background:linear-gradient(135deg,var(--navy),var(--blue-dark));padding-block:80px 60px;">
    <div class="container page-hero__inner">
        <span class="section-label reveal" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">{{ __('pages.glossary.hero_label') }}</span>
        <h1 class="reveal stagger-1" style="color:#fff;margin-top:12px;">{{ __('pages.glossary.hero_title') }}</h1>
        <p class="reveal stagger-2" style="color:rgba(255,255,255,0.65);font-size:18px;max-width:560px;margin-inline:auto;margin-top:12px;">
            {{ __('pages.glossary.hero_sub') }}
        </p>

        {{-- Recherche --}}
        <div class="faq-search reveal stagger-3" style="margin-top:28px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="search" id="glossary-search" class="faq-search__input"
                   placeholder="{{ __('pages.glossary.search_ph') }}"
                   aria-label="{{ __('pages.glossary.search_aria') }}">
        </div>
    </div>
</section>

<section style="background:var(--white);">
    <div class="container" style="max-width:900px;">

        {{-- Navigation A-Z --}}
        @php
        $terms = [
            'A' => [
                ['term'=>'Amortissement','def'=>'Remboursement progressif du capital emprunté au fil des mensualités. En début de prêt, la mensualité est composée en majorité d\'intérêts ; en fin de prêt, elle est composée en majorité de capital.'],
                ['term'=>'Apport personnel','def'=>'Somme que l\'emprunteur finance lui-même, sans recours au crédit. Un apport d\'au moins 10% est généralement exigé pour couvrir les frais de notaire. Un apport plus élevé améliore les conditions du prêt.'],
                ['term'=>'Assurance emprunteur','def'=>'Assurance obligatoire pour les prêts immobiliers, facultative pour les autres. Elle couvre le remboursement en cas de décès, invalidité ou incapacité de travail. Vous pouvez choisir librement votre assureur sous réserve de l\'équivalence des garanties.'],
                ['term'=>'Banco de Portugal (BdP)','def'=>'Banque centrale du Portugal et autorité de supervision prudentielle. Délivre les agréments aux institutions de crédit, veille à la stabilité du système financier et émet des recommandations macroprudentielles (notamment sur la taxa de esforço).'],
            ],
            'C' => [
                ['term'=>'Capacité d\'emprunt','def'=>'Montant maximum qu\'une personne peut emprunter compte tenu de ses revenus et charges. Elle est limitée par la taxa de esforço (50% des revenus nets, recommandation macroprudentielle du Banco de Portugal).'],
                ['term'=>'Capital restant dû','def'=>'Montant du prêt qu\'il reste à rembourser à un instant donné. Il sert de base de calcul pour les intérêts et pour les indemnités de remboursement anticipé.'],
                ['term'=>'Caution','def'=>'Garantie donnée par un tiers (personne physique ou organisme comme Crédit Logement) de rembourser le prêt en cas de défaillance de l\'emprunteur. Alternative moins coûteuse à l\'hypothèque.'],
                ['term'=>'Crédit à la consommation','def'=>'Prêt destiné à financer des biens ou services personnels (hors immobilier) : véhicule, travaux, voyage, etc. Montants de 200 à 75 000 €, durée jusqu\'à 84 mois.'],
                ['term'=>'Crédit revolving','def'=>'Crédit renouvelable qui se reconstitue au fur et à mesure des remboursements. Pratique mais souvent à taux élevé (jusqu\'à 21%). À utiliser avec prudence.'],
            ],
            'D' => [
                ['term'=>'Délégation d\'assurance','def'=>'Droit de choisir un assureur externe plutôt que celui proposé par la banque. Permet souvent d\'économiser 30 à 50% sur le coût de l\'assurance emprunteur.'],
                ['term'=>'Différé d\'amortissement','def'=>'Période pendant laquelle l\'emprunteur ne rembourse que les intérêts (différé partiel) ou ne rembourse rien (différé total). Utile pour les prêts travaux ou promoteurs immobiliers.'],
                ['term'=>'Durée du prêt','def'=>'Période totale de remboursement du crédit. Plus la durée est longue, plus les mensualités sont faibles mais le coût total élevé. La durée maximale est généralement de 25 ans pour l\'immobilier (27 ans avec différé).'],
            ],
            'E' => [
                ['term'=>'Taxa de esforço (taux d\'endettement)','def'=>'Rapport entre les charges de remboursement mensuelles et les revenus nets mensuels. Le Banco de Portugal recommande un plafond de 50% (DSTI — Debt Service-to-Income). Assurance emprunteur incluse dans le calcul. Des exceptions peuvent s\'appliquer pour une fraction des nouveaux crédits.'],
                ['term'=>'EURIBOR','def'=>'Euro Interbank Offered Rate. Taux de référence du marché monétaire européen, utilisé comme base des taux variables. Il est calculé quotidiennement pour différentes échéances (1 semaine, 1 mois, 3 mois, 6 mois, 12 mois).'],
            ],
            'F' => [
                ['term'=>'Frais de dossier','def'=>'Commission perçue par la banque pour l\'instruction et l\'administration du prêt. Généralement de 500 à 1 500 €. Négociables, surtout si le dossier est solide ou si vous passez par un courtier.'],
                ['term'=>'Frais de garantie','def'=>'Coût de la garantie apportée au prêt (caution ou hypothèque). Pour une caution Crédit Logement : 0,8 à 1,5% du capital. Pour une hypothèque : environ 2% (frais notaire inclus).'],
            ],
            'G' => [
                ['term'=>'Garantie','def'=>'Mécanisme qui protège le prêteur contre le risque de non-remboursement. Les deux principales formes sont la caution (Crédit Logement, caution mutuelle) et l\'hypothèque (sur un bien immobilier).'],
            ],
            'H' => [
                ['term'=>'DSTI (Debt Service-to-Income)','def'=>'Indicateur de soutenabilité du crédit, équivalent de la taxa de esforço. Rapport entre le total des remboursements mensuels de crédits et les revenus nets. Le Banco de Portugal recommande un DSTI maximal de 50% pour les nouveaux crédits à moyen-long terme.'],
                ['term'=>'Hypothèque','def'=>'Garantie réelle sur un bien immobilier : en cas de non-remboursement, le prêteur peut faire saisir et vendre le bien. L\'hypothèque est enregistrée chez le notaire. Elle s\'éteint automatiquement 1 an après la fin du prêt.'],
            ],
            'I' => [
                ['term'=>'IRA (Indemnités de Remboursement Anticipé)','def'=>'Pénalités dues en cas de remboursement anticipé. Pour le crédito habitação au Portugal (DL 74-A/2017), plafonnées à 0,5% du capital remboursé (taux variable) ou 2% (taux fixe). Pour le crédit à la consommation (DL 133/2009) : 1% ou 0,5% selon la durée restante.'],
                ['term'=>'RNMI (Registo Nacional de Mediadores de Crédito)','def'=>'Registre national portugais des intermédiaires de crédit (mediadores de crédito), géré par le Banco de Portugal. Équivalent de l\'ORIAS français. Tout intermédiaire en crédit doit y être inscrit et respecter des obligations déontologiques strictes (DL 81-C/2017).'],
            ],
            'L' => [
                ['term'=>'Leasing (ou crédit-bail)','def'=>'Contrat de location d\'un bien (véhicule, équipement) avec option d\'achat à terme. Les loyers sont souvent déductibles fiscalement pour les entreprises. Variantes : LOA (Location avec Option d\'Achat), LLD (Location Longue Durée).'],
                ['term'=>'LTV (Loan to Value)','def'=>'Ratio entre le montant du prêt et la valeur du bien financé. Un LTV de 80% signifie que vous empruntez 80% de la valeur du bien (apport de 20%). Plus le LTV est bas, meilleures sont les conditions du prêt.'],
            ],
            'M' => [
                ['term'=>'Mensualité','def'=>'Montant à rembourser chaque mois, comprenant capital remboursé + intérêts + assurance. Sa formule de calcul fait appel à la théorie des annuités : M = C × (r(1+r)^n) / ((1+r)^n - 1) où r est le taux mensuel et n le nombre de mois.'],
                ['term'=>'Microcrédit','def'=>'Prêt de faible montant (300 à 25 000 €) destiné aux personnes exclues du système bancaire classique. Il existe le microcrédit personnel (insertion sociale) et le microcrédit professionnel (création d\'entreprise).'],
                ['term'=>'Modulation','def'=>'Clause contractuelle permettant d\'augmenter ou réduire ses mensualités une fois par an, dans une fourchette définie (souvent ±30%). Utile pour adapter le remboursement à l\'évolution des revenus.'],
            ],
            'N' => [
                ['term'=>'Nantissement','def'=>'Garantie portant sur un actif financier (compte titres, assurance-vie, épargne salariale). Le prêteur se réserve le droit de saisir cet actif en cas de défaillance. Alternative à l\'hypothèque sans frais notariaux.'],
            ],
            'P' => [
                ['term'=>'Garantia Pública Habitação Jovem','def'=>'Dispositif d\'aide au Portugal permettant aux jeunes de moins de 35 ans d\'accéder à un crédit immobilier sans apport personnel suffisant, grâce à une garantie de l\'État portugais. Plafonné à 15% du prix du bien pour les résidences principales.'],
                ['term'=>'Crédito habitação (prêt immobilier)','def'=>'Prêt à long terme (jusqu\'à 40 ans au Portugal) destiné au financement d\'un bien immobilier : achat résidence principale, investissement locatif, construction ou travaux. Soumis au DL 74-A/2017 et à l\'obligation d\'assurance emprunteur.'],
            ],
            'R' => [
                ['term'=>'Rachat de crédit','def'=>'Regroupement de plusieurs crédits en cours (immobilier, conso, revolving) en un seul prêt, avec une mensualité réduite et une durée allongée. Permet d\'améliorer la capacité d\'emprunt mais augmente le coût total.'],
                ['term'=>'Remboursement anticipé','def'=>'Possibilité de rembourser tout ou partie du prêt avant l\'échéance prévue. Permet d\'économiser des intérêts. Soumis à des indemnités (IRA) plafonnées par la loi. Particulièrement intéressant en début de prêt.'],
                ['term'=>'RGPD','def'=>'Règlement Général sur la Protection des Données (Regulamento (UE) 2016/679). Réglementation européenne transposée au Portugal par la Lei n.º 58/2019. Encadre la collecte et le traitement des données personnelles. Supervisé au Portugal par la CNPD (Comissão Nacional de Proteção de Dados).'],
            ],
            'T' => [
                ['term'=>'TAEG (Taux Annuel Effectif Global)','def'=>'Indicateur de référence qui agrège tous les coûts du crédit : taux nominal, frais de dossier, assurance emprunteur, frais de garantie. Le seul indicateur qui permet de comparer équitablement deux offres de crédit.'],
                ['term'=>'Tableau d\'amortissement','def'=>'Document récapitulant, pour chaque échéance, la répartition entre capital remboursé, intérêts payés et capital restant dû. Obligatoirement fourni avec l\'offre de prêt immobilier.'],
                ['term'=>'Taux fixe','def'=>'Taux d\'intérêt qui ne varie pas pendant toute la durée du prêt. Offre sécurité et prévisibilité. Recommandé pour les prêts à long terme et lorsque les taux sont bas.'],
                ['term'=>'Taux variable','def'=>'Taux susceptible de varier selon l\'évolution d\'un indice de référence (souvent l\'EURIBOR). Peut baisser comme monter. Souvent assorti d\'un "cap" (plafond) pour limiter le risque.'],
            ],
            'U' => [
                ['term'=>'Usure (taux d\')','def'=>'Taux maximal légal au-delà duquel un prêt est considéré comme usuraire. Au Portugal, le taux maximum est fixé par décret et lié à l\'Euribor + spread réglementaire selon la catégorie de crédit. Le Banco de Portugal surveille le respect de ces plafonds.'],
            ],
        ];

        $letters = array_keys($terms);
        @endphp

        {{-- Barre alphabétique --}}
        <div style="position:sticky;top:var(--header-h);background:var(--white);z-index:10;padding-block:16px;margin-bottom:8px;border-bottom:1px solid rgba(38,123,241,0.07);" class="reveal">
            <div style="display:flex;gap:4px;flex-wrap:wrap;justify-content:center;">
                @foreach($letters as $l)
                <a href="#letter-{{ $l }}"
                   class="glossary-letter-btn"
                   id="nav-{{ $l }}"
                   aria-label="{{ __('pages.glossary.letter_aria') }} {{ $l }}">{{ $l }}</a>
                @endforeach
                <span style="width:1px;height:28px;background:rgba(38,123,241,0.12);margin-inline:4px;"></span>
                <button class="glossary-letter-btn" onclick="resetGlossary()" id="nav-all" style="letter-spacing:0;font-size:11px;padding-inline:10px;">{{ __('pages.glossary.all_btn') }}</button>
            </div>
        </div>

        {{-- État vide recherche --}}
        <div id="glossary-empty" style="display:none;text-align:center;padding:40px 0;">
            <p style="font-size:24px;margin-bottom:12px;">🔍</p>
            <p style="font-size:16px;color:var(--text-muted);">{{ __('pages.glossary.empty_full') }}</p>
        </div>

        {{-- Termes par lettre --}}
        @foreach($terms as $letter => $defs)
        <div class="glossary-section reveal" id="letter-{{ $letter }}" style="margin-bottom:40px;scroll-margin-top:120px;">
            <h2 class="font-mono" style="font-size:40px;color:var(--blue);margin-bottom:16px;border-bottom:2px solid rgba(38,123,241,0.12);padding-bottom:10px;">
                {{ $letter }}
            </h2>
            @foreach($defs as $d)
            <div class="glossary-item" data-term="{{ strtolower($d['term']) }}" data-def="{{ strtolower($d['def']) }}"
                 style="padding:18px 0;border-bottom:1px solid rgba(38,123,241,0.06);display:grid;grid-template-columns:220px 1fr;gap:24px;align-items:start;">
                <strong style="font-size:16px;color:var(--text);line-height:1.4;">{{ $d['term'] }}</strong>
                <p style="font-size:14px;color:var(--text-muted);line-height:1.7;margin:0;">{{ $d['def'] }}</p>
            </div>
            @endforeach
        </div>
        @endforeach

    </div>
</section>

{{-- CTA --}}
<section style="background:var(--cream);padding-block:60px 80px;">
    <div class="container" style="max-width:700px;text-align:center;">
        <h2 class="section-title reveal" style="font-size:28px;">{{ __('pages.glossary.cta_h2') }}</h2>
        <p class="section-desc reveal stagger-1">{{ __('pages.glossary.cta_p') }}</p>
        <div class="reveal stagger-2" style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:32px;">
            <a href="{{ route('contact.rdv') }}" class="btn btn-primary">{{ __('pages.glossary.cta_btn') }}</a>
            <a href="{{ route('faq') }}" class="btn btn-outline">{{ __('pages.glossary.cta_btn2') }}</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<style>
.glossary-letter-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: var(--radius-sm);
    font-size: 13px;
    font-weight: 700;
    color: var(--text-muted);
    background: transparent;
    border: 1px solid transparent;
    text-decoration: none;
    transition: all 0.15s;
    cursor: pointer;
    font-family: var(--font-mono);
}

.glossary-letter-btn:hover { background: rgba(38,123,241,0.08); color: var(--blue); border-color: rgba(38,123,241,0.15); }
.glossary-letter-btn.active { background: var(--blue); color: #fff; border-color: var(--blue); }
</style>
<script>
(function () {
    'use strict';

    var searchInput = document.getElementById('glossary-search');
    var sections    = document.querySelectorAll('.glossary-section');
    var items       = document.querySelectorAll('.glossary-item');
    var emptyState  = document.getElementById('glossary-empty');

    function filterGlossary() {
        var q = searchInput ? searchInput.value.toLowerCase().trim() : '';
        var visibleSections = 0;

        sections.forEach(function (sec) {
            var secVisible = 0;
            sec.querySelectorAll('.glossary-item').forEach(function (item) {
                var term = item.getAttribute('data-term') || '';
                var def  = item.getAttribute('data-def')  || '';
                var show = q === '' || term.indexOf(q) !== -1 || def.indexOf(q) !== -1;
                item.style.display = show ? '' : 'none';
                if (show) secVisible++;
            });
            sec.style.display = secVisible > 0 ? '' : 'none';
            if (secVisible > 0) visibleSections++;
        });

        emptyState.style.display = visibleSections === 0 ? 'block' : 'none';
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterGlossary);
    }

    window.resetGlossary = function () {
        if (searchInput) searchInput.value = '';
        filterGlossary();
        document.querySelectorAll('.glossary-letter-btn').forEach(function (b) { b.classList.remove('active'); });
        document.getElementById('nav-all') && document.getElementById('nav-all').classList.add('active');
    };

    // Active letter on scroll
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                var letter = entry.target.id.replace('letter-', '');
                document.querySelectorAll('.glossary-letter-btn').forEach(function (b) { b.classList.remove('active'); });
                var navBtn = document.getElementById('nav-' + letter);
                if (navBtn) navBtn.classList.add('active');
            }
        });
    }, { rootMargin: '-40% 0px -50% 0px' });

    sections.forEach(function (sec) { observer.observe(sec); });

    // Letter nav links
    document.querySelectorAll('.glossary-letter-btn[href]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            if (searchInput) searchInput.value = '';
            filterGlossary();
            var target = document.getElementById(a.getAttribute('href').slice(1));
            if (target) window.scrollTo({ top: target.offsetTop - 130, behavior: 'smooth' });
        });
    });
})();
</script>
@endsection
