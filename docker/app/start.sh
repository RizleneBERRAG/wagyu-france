#!/bin/sh
set -eu

cd /var/www

mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache

if [ ! -f .env ]; then
    cp .env.example .env
fi

composer install --no-interaction --prefer-dist

if ! grep -Eq '^APP_KEY=base64:.+' .env; then
    php artisan key:generate --force
fi

php artisan storage:link >/dev/null 2>&1 || true

# Environnement local uniquement : garantir l'écriture depuis PHP-FPM,
# quel que soit le système hôte (Windows/WSL, macOS ou Linux).
chmod -R 0777 storage bootstrap/cache || true

exec php-fpm
