# Buzer-lístek

Buzer-lístek is a small Yii2 web app for daily self-management: users create habit lists, track fulfillment, and review progress over time.

> ⚠️ Maintenance status: archived / unmaintained.

## What this project does

- User registration and login
- Daily habit list management
- Habit fulfillment tracking
- Basic profile and user management
- Optional Facebook OAuth login integration

## Tech stack

- PHP 8.2+ (use a release patched against CVE-2026-109618 / CVE-2026-109619: 8.2.35, 8.3.36, 8.4.27, 8.5.12 or newer)
- Yii2 (basic app structure)
- MySQL
- Bootstrap 4 (via `yiisoft/yii2-bootstrap4`)

## Project structure (high level)

- `controllers/` – request handling and page actions
- `models/dao/` – database-backed models
- `models/forms/` – form validation and submission logic
- `views/` – UI templates
- `config/` – environment and application configuration
- `www/` – web root (entry point, static assets)

## Local setup

1. Install PHP and Composer.
2. Install dependencies:
   ```bash
   composer install
   ```
3. Create database config file `config/db.ini` (not committed):
   ```ini
   [dev]
   host = "127.0.0.1"
   db = "buzerlistek"
   user = "your_db_user"
   password = "your_db_password"

   [prod]
   host = "127.0.0.1"
   db = "buzerlistek"
   user = "your_db_user"
   password = "your_db_password"
   ```
4. (Optional) Set Facebook OAuth credentials in `config/facebook.ini`.
5. Start the built-in server:
   ```bash
   php yii serve --docroot=@app/www
   ```
6. Open `http://localhost:8080`.

## Security cleanup note

As part of repository maintenance, embedded API credentials were removed from versioned config files. Keep secrets only in local, untracked configuration.

## Legacy notes

- The codebase was originally built for an older Yii2 / PHP 7 ecosystem.
- In October 2026 dependencies were upgraded to current stable releases (Yii 2.0.55, Bootstrap 4.6, Symfony Mailer instead of SwiftMailer) and the minimum PHP version was raised to 8.2.
- The Codeception tests under `tests/` are leftovers from the Yii basic app template and do not match this application.
