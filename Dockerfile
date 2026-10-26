# syntax=docker/dockerfile:1
#
# Dockerfile untuk Halent Parfum (Laravel 13 + Filament 3) di Render.
# Membutuhkan PHP ^8.4.1 (sesuai composer.json).
#
# Alur build:
#   base     -> PHP 8.4 + nginx + php-fpm, ditambah ekstensi intl (dibutuhkan Filament)
#   vendor   -> composer install (tanpa paket dev)
#   frontend -> npm run build (Vite + Tailwind). Butuh folder vendor karena
#               resources/css/app.css memindai view pagination milik Laravel.
#   app      -> image final yang dijalankan Render

# ---------- base ----------
FROM serversideup/php:8.4-fpm-nginx AS base

USER root
# pdo_pgsql, pdo_mysql, dan zip sudah ada di image ini. Filament butuh intl.
RUN install-php-extensions intl

WORKDIR /var/www/html
RUN chown www-data:www-data /var/www/html

# ---------- vendor ----------
FROM base AS vendor

COPY --chown=www-data:www-data composer.json composer.lock ./
USER www-data
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --no-interaction \
    --prefer-dist

# ---------- frontend ----------
FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund

COPY vite.config.js ./
COPY resources ./resources
COPY public ./public
COPY --from=vendor /var/www/html/vendor ./vendor

# Catatan: vite.config.js memakai plugin fonts (bunny) yang mengunduh font
# "Instrument Sans" dari fonts.bunny.net saat build. Butuh akses internet.
RUN npm run build

# ---------- app (final) ----------
FROM base AS app

# serversideup/php: AUTORUN menjalankan migrasi dan optimize otomatis saat container start.
# - Route cache DIMATIKAN karena routes/web.php memakai closure (route:cache akan gagal).
# - storage:link dimatikan karena aplikasi tidak memakai Storage/upload.
# - Seeder tidak dijalankan otomatis (atur AUTORUN_LARAVEL_MIGRATION_SEED di Render bila perlu).
ENV PHP_OPCACHE_ENABLE=1 \
    AUTORUN_ENABLED=true \
    AUTORUN_LARAVEL_MIGRATION=true \
    AUTORUN_LARAVEL_STORAGE_LINK=false \
    AUTORUN_LARAVEL_ROUTE_CACHE=false

USER www-data

COPY --chown=www-data:www-data . .
COPY --chown=www-data:www-data --from=vendor /var/www/html/vendor ./vendor
COPY --chown=www-data:www-data --from=frontend /app/public/build ./public/build

RUN mkdir -p \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && composer dump-autoload --optimize --no-dev --no-scripts
