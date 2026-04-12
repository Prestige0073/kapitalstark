# Architecture & Base de données

## Modèles Eloquent

### User
**Fichier :** `app/Models/User.php`
- Champs fillable : `name`, `email`, `password`
- Authentification standard Laravel (Espace Client)

> Modèles métier à créer : Loan, LoanType, LoanApplication, Document, BlogPost, Testimonial, FAQ, etc.

---

## Routes prévues

### Pages publiques
| URI | Vue | Description |
|---|---|---|
| `/` | `home` | Page d'accueil |
| `/prets/{type}` | `loans.show` | Page type de prêt (×6) |
| `/simulateur` | `simulator` | Simulateur de prêt complet |
| `/a-propos` | `about` | Page À Propos |
| `/blog` | `blog.index` | Liste des articles |
| `/blog/{slug}` | `blog.show` | Article individuel |
| `/contact` | `contact` | Formulaire de contact |
| `/faq` | `faq` | FAQ |
| `/glossaire` | `glossary` | Glossaire financier |
| `/mentions-legales` | `legal.mentions` | Mentions légales |
| `/cgu` | `legal.cgu` | CGU |
| `/confidentialite` | `legal.privacy` | Politique de confidentialité |

### Espace Client (auth)
| URI | Vue | Description |
|---|---|---|
| `/login` | `auth.login` | Connexion |
| `/register` | `auth.register` | Inscription |
| `/dashboard` | `client.dashboard` | Accueil dashboard |
| `/dashboard/prets` | `client.loans` | Mes prêts |
| `/dashboard/demandes` | `client.applications` | Mes demandes |
| `/dashboard/documents` | `client.documents` | Mes documents |
| `/dashboard/messages` | `client.messages` | Messagerie |
| `/dashboard/profil` | `client.profile` | Mon profil |
| `/dashboard/rendez-vous` | `client.appointments` | Calendrier RDV |

### API (interne)
| URI | Description |
|---|---|
| `POST /api/simulateur/calcul` | Calcul mensualité en temps réel |
| `POST /api/contact` | Envoi formulaire de contact |
| `POST /api/newsletter` | Inscription newsletter |

---

## Migrations (existantes)

| Table | Description |
|---|---|
| `users` | Utilisateurs / Espace Client |
| `password_reset_tokens` | Réinitialisation mot de passe |
| `sessions` | Sessions database |
| `cache`, `cache_locks` | Cache database |
| `jobs`, `job_batches`, `failed_jobs` | Queue database |

---

## Structure des vues Blade (prévue)
```
resources/views/
  layouts/
    app.blade.php        # Layout principal (header + footer + chat)
    client.blade.php     # Layout espace client (sidebar)
  components/
    header.blade.php
    footer.blade.php
    chat-widget.blade.php
    loan-card.blade.php
    simulator.blade.php
    testimonial-card.blade.php
  home/
    index.blade.php
  loans/
    show.blade.php
  simulator/
    index.blade.php
  client/
    dashboard.blade.php
    loans.blade.php
    ...
```
