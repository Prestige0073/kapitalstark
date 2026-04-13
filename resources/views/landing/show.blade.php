<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">{{-- Landing pages hors SEO organique --}}
    <title>{{ $title }} — KapitalStark</title>
    <meta name="description" content="{{ $page['subtitle'] }}">

    <!-- Schema FAQPage -->
    @if($faqs->isNotEmpty())
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "FAQPage",
      "mainEntity": [
        @foreach($faqs as $faq)
        {"@@type":"Question","name":{{ json_encode($faq->question,JSON_UNESCAPED_UNICODE) }},"acceptedAnswer":{"@@type":"Answer","text":{{ json_encode(strip_tags($faq->answer),JSON_UNESCAPED_UNICODE) }}}}{{ !$loop->last ? ',' : '' }}
        @endforeach
      ]
    }
    </script>
    @endif

    @include('components.gtag', ['section' => 'head', 'pageType' => 'landing_' . $page['loan_type']])

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* ── Landing page styles ── */
        .lp-body { background: #f8fafd; font-family: 'DM Sans', sans-serif; }
        .lp-nav { background: #fff; border-bottom: 1px solid #e8edf5; padding: 14px 24px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
        .lp-nav__logo { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; color: #0f1c36; text-decoration: none; }
        .lp-nav__tel { display: flex; align-items: center; gap: 8px; color: #267BF1; font-weight: 600; text-decoration: none; font-size: 15px; }
        .lp-hero { background: linear-gradient(135deg, #0f1c36 0%, #1a3a6b 100%); padding: 64px 24px 80px; text-align: center; }
        .lp-hero__label { display: inline-block; background: rgba(38,123,241,.2); color: #7eb8ff; border: 1px solid rgba(38,123,241,.3); border-radius: 20px; padding: 4px 16px; font-size: 13px; font-weight: 500; margin-bottom: 20px; letter-spacing: .5px; }
        .lp-hero__h1 { font-family: 'Playfair Display', serif; font-size: clamp(28px, 5vw, 48px); color: #fff; margin: 0 auto 16px; max-width: 800px; line-height: 1.2; }
        .lp-hero__sub { color: rgba(255,255,255,.7); font-size: clamp(15px, 2vw, 18px); max-width: 560px; margin: 0 auto 40px; }
        .lp-trust { display: flex; gap: 32px; justify-content: center; flex-wrap: wrap; margin-top: 40px; }
        .lp-trust__item { text-align: center; color: #fff; }
        .lp-trust__val { font-family: 'Space Mono', monospace; font-size: 24px; font-weight: 700; color: #267BF1; }
        .lp-trust__lbl { font-size: 13px; color: rgba(255,255,255,.6); margin-top: 4px; }
        /* Formulaire */
        .lp-form-wrap { max-width: 560px; margin: -40px auto 0; position: relative; z-index: 10; padding: 0 16px; }
        .lp-form { background: #fff; border-radius: 16px; padding: 32px; box-shadow: 0 8px 40px rgba(15,28,54,.15); }
        .lp-form__title { font-family: 'Playfair Display', serif; font-size: 20px; color: #0f1c36; margin: 0 0 24px; text-align: center; }
        .lp-form__grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .lp-form__group { display: flex; flex-direction: column; gap: 6px; }
        .lp-form__group--full { grid-column: 1 / -1; }
        .lp-form__label { font-size: 13px; font-weight: 500; color: #4a5568; }
        .lp-form__input { border: 1.5px solid #dce4f0; border-radius: 8px; padding: 10px 14px; font-size: 14px; font-family: inherit; outline: none; transition: border-color .2s; }
        .lp-form__input:focus { border-color: #267BF1; box-shadow: 0 0 0 3px rgba(38,123,241,.12); }
        .lp-form__btn { width: 100%; padding: 14px; background: #267BF1; color: #fff; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; font-family: inherit; cursor: pointer; margin-top: 8px; transition: background .2s, transform .15s; }
        .lp-form__btn:hover { background: #1a6bd4; transform: translateY(-1px); }
        .lp-form__note { text-align: center; font-size: 11px; color: #94a3b8; margin-top: 10px; }
        /* Sections */
        .lp-section { padding: 72px 24px; }
        .lp-container { max-width: 900px; margin: 0 auto; }
        .lp-section-title { font-family: 'Playfair Display', serif; font-size: clamp(22px, 3vw, 32px); color: #0f1c36; text-align: center; margin-bottom: 48px; }
        /* Avantages */
        .lp-benefits { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .lp-benefit { text-align: center; padding: 28px 20px; background: #fff; border-radius: 12px; border: 1px solid #e8edf5; }
        .lp-benefit__icon { width: 48px; height: 48px; background: rgba(38,123,241,.08); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        .lp-benefit__title { font-weight: 600; color: #0f1c36; margin-bottom: 8px; font-size: 15px; }
        .lp-benefit__text { font-size: 13px; color: #64748b; line-height: 1.6; }
        /* CTA bannière */
        .lp-cta-band { background: #267BF1; padding: 40px 24px; text-align: center; }
        .lp-cta-band__title { font-family: 'Playfair Display', serif; font-size: clamp(20px, 3vw, 28px); color: #fff; margin-bottom: 20px; }
        .lp-cta-band__btn { display: inline-block; background: #fff; color: #267BF1; padding: 14px 36px; border-radius: 10px; font-weight: 700; text-decoration: none; font-size: 16px; transition: transform .15s; }
        .lp-cta-band__btn:hover { transform: translateY(-2px); }
        /* FAQ */
        .lp-faq { background: #f8fafd; }
        .faq-accordion__item { border: 1px solid #dce4f0; border-radius: 10px; margin-bottom: 10px; overflow: hidden; }
        .faq-accordion__question { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; cursor: pointer; font-weight: 500; color: #0f1c36; list-style: none; font-size: 15px; }
        .faq-accordion__question::-webkit-details-marker { display: none; }
        details[open] .faq-accordion__icon { transform: rotate(180deg); }
        .faq-accordion__icon { transition: transform .25s; flex-shrink: 0; color: #267BF1; }
        .faq-accordion__answer { padding: 0 20px 16px; color: #4a5568; font-size: 14px; line-height: 1.7; }
        /* Urgence */
        .lp-urgency { background: #fff3cd; border: 1px solid #ffc107; border-radius: 10px; padding: 16px 24px; text-align: center; margin: 24px auto; max-width: 600px; font-size: 14px; color: #856404; font-weight: 500; }
        /* Footer minimal */
        .lp-footer { background: #0f1c36; color: rgba(255,255,255,.5); text-align: center; padding: 24px; font-size: 12px; }
        .lp-footer a { color: rgba(255,255,255,.5); text-decoration: none; }
        /* Alert succès */
        .lp-alert { background: #d1fae5; border: 1px solid #34d399; color: #065f46; border-radius: 10px; padding: 16px 20px; margin-bottom: 20px; font-size: 14px; }
        @media(max-width:640px) {
            .lp-form__grid { grid-template-columns: 1fr; }
            .lp-benefits { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body class="lp-body">

@include('components.gtag', ['section' => 'body'])

<!-- Navigation -->
<nav class="lp-nav">
    <a href="{{ url('/') }}" class="lp-nav__logo">KapitalStark</a>
    <a href="tel:+351210001234" class="lp-nav__tel" data-gtag="phone_call">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8a19.79 19.79 0 01-3.07-8.67A2 2 0 012 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14z"/></svg>
        +351 21 000 1234
    </a>
</nav>

<!-- Hero -->
<section class="lp-hero">
    <div class="lp-hero__label">{{ $page['keyword'] }}</div>
    <h1 class="lp-hero__h1">{{ $title }}</h1>
    <p class="lp-hero__sub">{{ $page['subtitle'] }}</p>

    <div class="lp-trust">
        <div class="lp-trust__item">
            <div class="lp-trust__val">{{ $page['trust_stats']['clients'] }}</div>
            <div class="lp-trust__lbl">clients accompagnés</div>
        </div>
        <div class="lp-trust__item">
            <div class="lp-trust__val">{{ $page['trust_stats']['years'] }}</div>
            <div class="lp-trust__lbl">d'expérience</div>
        </div>
        <div class="lp-trust__item">
            <div class="lp-trust__val">{{ $page['trust_stats']['rate'] }}</div>
            <div class="lp-trust__lbl">taux indicatif</div>
        </div>
    </div>
</section>

<!-- Formulaire (above the fold) -->
<div class="lp-form-wrap">
    <div class="lp-form">
        @if(session('success'))
        <div class="lp-alert">{{ session('success') }}</div>
        @endif

        <p class="lp-form__title">Obtenez votre offre gratuite</p>
        <form method="POST" action="{{ route('landing.submit', $type) }}" id="lp-form">
            @csrf
            <div class="lp-form__grid">
                <div class="lp-form__group">
                    <label class="lp-form__label" for="prenom">Prénom *</label>
                    <input class="lp-form__input" type="text" id="prenom" name="prenom" required placeholder="Jean" value="{{ old('prenom') }}">
                </div>
                <div class="lp-form__group">
                    <label class="lp-form__label" for="nom">Nom *</label>
                    <input class="lp-form__input" type="text" id="nom" name="nom" required placeholder="Dupont" value="{{ old('nom') }}">
                </div>
                <div class="lp-form__group">
                    <label class="lp-form__label" for="montant_souhaite">Montant souhaité (€) *</label>
                    <input class="lp-form__input" type="number" id="montant_souhaite" name="montant_souhaite" required min="1000" placeholder="150 000" value="{{ old('montant_souhaite') }}">
                </div>
                <div class="lp-form__group">
                    <label class="lp-form__label" for="duree">Durée (mois) *</label>
                    <input class="lp-form__input" type="number" id="duree" name="duree" required min="6" max="360" placeholder="240" value="{{ old('duree') }}">
                </div>
                <div class="lp-form__group">
                    <label class="lp-form__label" for="telephone">Téléphone *</label>
                    <input class="lp-form__input" type="tel" id="telephone" name="telephone" required placeholder="+351 9X XXX XXXX" value="{{ old('telephone') }}">
                </div>
                <div class="lp-form__group">
                    <label class="lp-form__label" for="email">E-mail *</label>
                    <input class="lp-form__input" type="email" id="email" name="email" required placeholder="jean@exemple.fr" value="{{ old('email') }}">
                </div>
                <div class="lp-form__group">
                    <label class="lp-form__label" for="revenus_mensuels">Revenus mensuels (€) *</label>
                    <input class="lp-form__input" type="number" id="revenus_mensuels" name="revenus_mensuels" required min="0" placeholder="3 500" value="{{ old('revenus_mensuels') }}">
                </div>
                <div class="lp-form__group">
                    <label class="lp-form__label" for="objet_pret">Objet du prêt</label>
                    <input class="lp-form__input" type="text" id="objet_pret" name="objet_pret" placeholder="{{ $prefill['objet'] ?: 'Ex: résidence principale' }}" value="{{ old('objet_pret', $prefill['objet']) }}">
                </div>
            </div>
            <button type="submit" class="lp-form__btn" id="lp-submit-btn">
                Recevoir mon offre gratuite →
            </button>
            <p class="lp-form__note">Sans engagement · Réponse sous 24h · 100% gratuit</p>
        </form>
    </div>
</div>

<!-- Urgence -->
<div style="max-width:900px;margin:0 auto;padding:0 16px;">
    <div class="lp-urgency">
        ⏰ Offre limitée — Taux préférentiel disponible jusqu'au {{ now()->endOfMonth()->format('d/m/Y') }}
    </div>
</div>

<!-- Avantages -->
<section class="lp-section" style="background:#fff;">
    <div class="lp-container">
        <h2 class="lp-section-title">Pourquoi choisir KapitalStark ?</h2>
        <div class="lp-benefits">
            <div class="lp-benefit">
                <div class="lp-benefit__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#267BF1" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="lp-benefit__title">Taux compétitifs</div>
                <div class="lp-benefit__text">Nous négocions pour vous les meilleures conditions auprès de nos partenaires bancaires.</div>
            </div>
            <div class="lp-benefit">
                <div class="lp-benefit__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#267BF1" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="lp-benefit__title">Réponse rapide</div>
                <div class="lp-benefit__text">Première réponse de principe sous 24h. Dossier complet traité en 48 à 72h.</div>
            </div>
            <div class="lp-benefit">
                <div class="lp-benefit__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#267BF1" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
                <div class="lp-benefit__title">Accompagnement dédié</div>
                <div class="lp-benefit__text">Un conseiller personnel vous accompagne de la simulation jusqu'au déblocage des fonds.</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA milieu -->
<div class="lp-cta-band">
    <h3 class="lp-cta-band__title">Prêt à concrétiser votre projet ?</h3>
    <a href="#lp-form" class="lp-cta-band__btn">Faire ma demande maintenant</a>
</div>

<!-- FAQ -->
@if($faqs->isNotEmpty())
<section class="lp-section lp-faq">
    <div class="lp-container">
        <h2 class="lp-section-title">Questions fréquentes — {{ $page['keyword'] }}</h2>
        @include('components.faq-accordion', ['faqs' => $faqs, 'pageTitle' => $page['keyword']])
    </div>
</section>
@endif

<!-- CTA bas -->
<div class="lp-cta-band" style="background:#0f1c36;">
    <h3 class="lp-cta-band__title">Ne manquez pas cette opportunité</h3>
    <a href="#lp-form" class="lp-cta-band__btn">Obtenir mon offre gratuite</a>
</div>

<!-- Footer minimal -->
<footer class="lp-footer">
    <p>© {{ date('Y') }} KapitalStark · <a href="{{ route('legal') }}">Mentions légales</a> · <a href="{{ route('privacy') }}">Confidentialité</a></p>
    <p style="margin-top:8px;">KapitalStark — Avenida da Liberdade, 110, Lisboa · +351 21 000 1234</p>
</footer>

@include('components.gtag', ['section' => 'events'])

<script>
// Conversion GTM au submit du formulaire
document.getElementById('lp-form').addEventListener('submit', function(){
    if(window.dataLayer) {
        dataLayer.push({
            'event': 'form_submit',
            'conversion_type': 'landing_submit',
            'loan_type': '{{ $page["loan_type"] }}'
        });
    }
    @php $convId = config('google_ads.conversion_id'); @endphp
    @if($convId)
    if(typeof gtag !== 'undefined') {
        gtag('event', 'conversion', {
            'send_to': '{{ $convId }}',
            'value': 75.0,
            'currency': 'EUR'
        });
    }
    @endif
});
</script>

</body>
</html>
