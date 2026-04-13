# KapitalStark — Contexte projet pour Claude

## Vue d'ensemble
**Site web de prêt bancaire** — Institution financière moderne, fiable et accessible.
Slogan : *"Votre avenir financier commence ici"*
État actuel : **Phase 3 — SEO & Acquisition** (application complète : pages, dashboard, admin, blog, simulateur, messagerie, virements, chat — SEO/Google Ads en place)

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

#### Module 1 — Schema Markup & Knowledge Panel ✅
- [x] Créer `App\Services\SchemaMarkupService`
- [x] JSON-LD : Organization + FinancialService (Knowledge Panel)
- [x] JSON-LD : WebPage par type (HomePage, Service, FAQ, Article, Contact)
- [x] JSON-LD : BreadcrumbList dynamique sur toutes les pages intérieures
- [x] Migration + Model `seo_settings` (meta title/desc/robots/canonical/schema_json par page)
- [x] ViewComposer + SeoMiddleware pour injecter les schemas dans `<head>`

#### Module 2 — Featured Snippets (Position Zéro) ✅
- [x] Migration + Model `faqs` (question, answer, category, page_slug, is_published, sort_order)
- [x] Composant Blade `faq-accordion.blade.php` (accordéon `<details>/<summary>` + Schema FAQPage)
- [x] `PageController@faq` : charge les FAQs depuis DB groupées par catégorie
- [x] Schema FAQPage injecté sur /faq et pages de service

#### Module 3 — SEO Technique Laravel ✅
- [x] `SeoMiddleware` : X-Robots-Tag, Cache-Control, partage seoSettings
- [x] Route `/sitemap.xml` existante (urls statiques avec priority/changefreq)
- [x] Meta tags dynamiques dans layout Blade : title, description, OG, Twitter Card, canonical
- [x] `@yield('schema')` pour schémas supplémentaires par page

#### Module 4 — Google Ads Tracking & Conversions ✅
- [x] `App\Services\GoogleAdsTrackingService` (GTM injection)
- [x] Variables `.env` à renseigner : GTM_CONTAINER_ID, GOOGLE_ADS_ID, GOOGLE_ADS_CONVERSION_ID
- [x] Composant Blade `gtag.blade.php` (GTM head/body/events + dataLayer)
- [x] Événements auto : clic tel, PDF, scroll 75%, temps > 3min
- [x] `config/google_ads.php`
- [x] Migration + Model `ad_conversions` (gclid, IP anonymisée RGPD)

#### Module 5 — Landing Pages Google Ads ✅
- [x] Routes `/lp/{type}` + `LandingPageController`
- [x] Capture UTM + GCLID (session + cookie 30j)
- [x] 4 types : pret-immobilier, pret-automobile, pret-personnel, pret-entreprise
- [x] A/B testing simple (variante a/b via cookie)
- [x] Formulaire avec validation FR, email admin, conversion GTM

#### Module 6 — Google Business Profile (Local SEO) ✅
- [x] `PageController@agencies` avec données structurées 2 agences (Lisboa + Porto)
- [x] Schema `LocalBusiness` JSON-LD sur la page /a-propos/agences
- [x] Fichier `public/.well-known/business_data.json`
- [ ] Google Maps embed sur la page agences (à implémenter dans la vue)

### Corrections & Améliorations en cours
- [x] Favicon Google Search : suppression favicon-32.png manquant, ajout site.webmanifest
- [x] robots.txt : correction URL sitemap → kapitalstarks.com
- [x] Messagerie admin/user : polling backoff, typing indicator, read receipts
- [x] Responsive mobile admin : topbar fixed, overflow tables, breakpoints 420-900px

---
*Mis à jour automatiquement à chaque évolution du projet.*
