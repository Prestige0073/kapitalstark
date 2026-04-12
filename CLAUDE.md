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
*Mis à jour automatiquement à chaque évolution du projet.*
