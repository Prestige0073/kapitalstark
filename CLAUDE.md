# KapitalStark — Contexte projet pour Claude

## Vue d'ensemble
**Site web de prêt bancaire** — Institution financière moderne, fiable et accessible.
Slogan : *"Votre avenir financier commence ici"*
État actuel : **Phase 1 — Structure & Infrastructure** (squelette Laravel en place, aucune page métier implémentée)

## Stack technique
- **Backend :** Laravel 13 / PHP 8.3
- **Base de données :** MySQL (base : `kapitalstark`)
- **Frontend :** HTML/CSS/JS vanilla — fichiers servis depuis `public/css/` et `public/js/` (pas de Vite)
- **Sessions / Queue / Cache :** drivers `database`
- **Tests :** PHPUnit

## Commandes utiles
```bash
php artisan serve    # Lance le serveur de développement
composer run test    # Lance la suite de tests
php artisan migrate  # Applique les migrations
```

## Structure clé
```
app/
  Http/Controllers/   # Contrôleurs (vide pour l'instant)
  Models/             # Modèles Eloquent
public/
  css/                # Styles CSS vanilla
  js/                 # Scripts JS vanilla
resources/
  views/              # Templates Blade
routes/
  web.php             # Routes web
database/
  migrations/         # Schéma de la base
```

## Documentation détaillée
- [Architecture & Routes](docs/architecture.md)
- [Fonctionnalités & Progression](docs/features.md)
- [Stack & Configuration](docs/stack.md)
- [Design UI/UX](docs/design.md)

## Règles de sécurité ABSOLUES
- **Toute suppression majeure** (truncate, drop, delete en masse, suppression de fichiers critiques, reset de base de données) **nécessite la confirmation explicite de l'utilisateur avant d'être exécutée**, sans exception.
- Ne jamais supposer que l'utilisateur a accepté une suppression majeure implicitement.

## Règles de design ABSOLUES
- **Zéro violet / mauve / lavande** — interdit partout, aucune nuance
- Couleur dominante : **Bleu ciel #267BF1**
- Polices : **Playfair Display** (titres) + **DM Sans** (corps) + **Space Mono** (chiffres)
- Toutes les animations : `transform` + `opacity` (GPU, pas JS lourd)
- Score Lighthouse visé : **90+** sur toutes les métriques

---

## Suivi des tâches

### SEO & Google Ads — 6 modules

#### Module 1 — Schema Markup & Knowledge Panel
- [ ] Créer `App\Services\SchemaMarkupService`
- [ ] JSON-LD : Organization + FinancialService (Knowledge Panel)
- [ ] JSON-LD : WebPage par type (HomePage, Service, FAQ, Article, Contact)
- [ ] JSON-LD : BreadcrumbList dynamique sur toutes les pages intérieures
- [ ] Migration + Model + Controller CRUD `seo_settings`
- [ ] ViewComposer ou Middleware pour injecter les schemas dans `<head>`

#### Module 2 — Featured Snippets (Position Zéro)
- [ ] Migration + Model `faqs` (question, answer, category, page_slug, is_published, sort_order)
- [ ] Composant Blade `faq-accordion.blade.php` (accordéon `<details>/<summary>` + Schema FAQPage)
- [ ] Structurer les pages de service : h2/h3, ul/ol, table, réponses courtes
- [ ] Page publique `/faq` groupée par catégorie

#### Module 3 — SEO Technique Laravel
- [ ] `SeoMiddleware` : X-Robots-Tag, Cache-Control, canonical automatique
- [ ] Route `/sitemap.xml` dynamique (pages publiques, lastmod, changefreq, priority)
- [ ] Route `/robots.txt` dynamique
- [ ] Meta tags dynamiques dans layout Blade : title, description, OG, Twitter Card, canonical, hreflang
- [ ] Core Web Vitals : lazy loading images, preload fonts/LCP, headers cache

#### Module 4 — Google Ads Tracking & Conversions
- [ ] `App\Services\GoogleAdsTrackingService` (GTM injection)
- [ ] Variables `.env` : GOOGLE_ADS_ID, GOOGLE_ADS_CONVERSION_ID, GTM_CONTAINER_ID
- [ ] Composant Blade `gtag.blade.php` (GTM head + body + dataLayer)
- [ ] Événements : soumission formulaire, clic simulateur, appel tel, PDF, scroll 75%, temps > 3min
- [ ] `config/google_ads.php`
- [ ] Migration + Model `ad_conversions` (gclid, conversion_type, ip anonymisée)

#### Module 5 — Landing Pages Google Ads
- [ ] Routes `/lp/*` + `LandingPageController`
- [ ] Capture UTM + GCLID (session + cookie 30j)
- [ ] Structure landing page Blade : Hero, confiance, formulaire above-fold, FAQ, avis, CTA x3
- [ ] A/B testing simple (2 variantes de titre via config)
- [ ] `DemandePretForm` : validation FR, enregistrement DB, email, conversion GTM

#### Module 6 — Google Business Profile (Local SEO)
- [ ] Page `/agences` ou `/contact` avec Google Maps embed
- [ ] Schema `LocalBusiness` pour chaque agence
- [ ] Fichier `public/.well-known/business_data.json`
- [ ] Footer : adresse structurée itemprop + liens réseaux sociaux

### Corrections & Améliorations en cours
- [x] Favicon Google Search : suppression favicon-32.png manquant, ajout site.webmanifest
- [x] robots.txt : correction URL sitemap → kapitalstarks.com
- [x] Messagerie admin/user : polling backoff, typing indicator, read receipts
- [x] Responsive mobile admin : topbar fixed, overflow tables, breakpoints 420-900px

---
*Mis à jour automatiquement à chaque évolution du projet.*
