#!/bin/sh
set -eu
mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs /data
# ponytail: APP_KEY persisten di /data; pindah ke secret manager kalau ada rotasi key.
if [ -z "${APP_KEY:-}" ]; then
  [ -f /data/app.key ] || head -c 32 /dev/urandom | base64 | tr -d '\n' > /data/app.key
  APP_KEY="base64:$(cat /data/app.key)"
  export APP_KEY
fi
[ -f "$DB_DATABASE" ] || touch "$DB_DATABASE"
php artisan migrate --force --no-interaction
if [ "$(php -r 'echo (new PDO("sqlite:".getenv("DB_DATABASE")))->query("SELECT COUNT(*) FROM users")->fetchColumn();')" = "0" ]; then
  php artisan db:seed --force --no-interaction
fi
php artisan storage:link --force >/dev/null 2>&1 || true
php artisan config:cache >/dev/null
# ponytail: artisan serve = 1 worker pool; ganti ke php-fpm/frankenphp kalau trafik naik.
exec php artisan serve --host=0.0.0.0 --port=8080
