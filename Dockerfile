FROM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json .npmrc ./
RUN npm ci
COPY . .
RUN npm run build

FROM composer:2 AS vendor
WORKDIR /app
COPY --from=assets /app /app
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist --optimize-autoloader

FROM php:8.4-cli-alpine
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS sqlite-dev libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" pdo_sqlite gd \
    && apk del .build-deps \
    && apk add --no-cache sqlite-libs libpng libjpeg-turbo libwebp freetype
RUN printf "upload_max_filesize=32M\npost_max_size=40M\nmemory_limit=256M\n" > /usr/local/etc/php/conf.d/uploads.ini
WORKDIR /app
COPY --from=vendor /app /app
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh && mkdir -p /data
ENV APP_ENV=production \
    APP_DEBUG=false \
    DB_CONNECTION=sqlite \
    DB_DATABASE=/data/database.sqlite \
    SESSION_DRIVER=file \
    CACHE_STORE=file \
    QUEUE_CONNECTION=sync \
    LOG_CHANNEL=stderr
EXPOSE 8080
# ponytail: artisan serve (single process) cukup untuk portfolio traffic rendah; ganti ke php-fpm+nginx/frankenphp kalau perlu concurrency.
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
