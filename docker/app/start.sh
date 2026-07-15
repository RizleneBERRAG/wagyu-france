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

chmod -R ug+rwX storage bootstrap/cache || true

exec php-fpm
