#!/bin/sh

set -eu

cd /var/www/html

: "${APP_KEY:?Set APP_KEY in the Render environment}"
: "${DB_URL:?Set DB_URL to the Render PostgreSQL internal URL}"

export DB_CONNECTION="${DB_CONNECTION:-pgsql}"

echo "Running database migrations..."
php artisan migrate --force

echo "Seeding initial catalog data..."
php artisan db:seed --force

echo "Caching Laravel configuration and views..."
php artisan config:cache
php artisan view:cache

echo "Starting the Laravel web server..."
exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
