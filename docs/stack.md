# Stack & Configuration

## Dépendances PHP (composer.json)
- `laravel/framework` ^13.0
- `laravel/tinker` ^2.10.1

## Frontend
- HTML/CSS/JS vanilla — fichiers servis depuis `public/css/` et `public/js/`
- Pas de build tool (Vite supprimé)
- Polices via Google Fonts : Playfair Display, DM Sans, Space Mono / JetBrains Mono

## Variables d'environnement clés (.env)
| Variable | Valeur |
|---|---|
| `APP_NAME` | KapitalStark |
| `APP_ENV` | local |
| `APP_DEBUG` | true |
| `DB_CONNECTION` | mysql |
| `DB_DATABASE` | kapitalstark |
| `SESSION_DRIVER` | database |
| `QUEUE_CONNECTION` | database |
| `CACHE_STORE` | database |
| `MAIL_MAILER` | log |

## Configuration auth
- Guard par défaut : `web` (session)
- Provider : Eloquent → `App\Models\User`

## Fichiers de config
- `config/app.php` — Application
- `config/auth.php` — Authentification
- `config/database.php` — Connexions DB
- `config/session.php` — Sessions
- `config/cache.php` — Cache
- `config/queue.php` — Queue
- `config/mail.php` — Mail
- `config/filesystems.php` — Stockage fichiers
- `config/logging.php` — Logs
- `config/services.php` — Services tiers
