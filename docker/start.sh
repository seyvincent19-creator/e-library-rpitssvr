#!/bin/sh
set -e

# Run database migrations
php artisan migrate --force

# Seed database (idempotent — uses firstOrCreate, safe to run every deploy)
php artisan db:seed --force

# Cache config/routes/views for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Start php-fpm in background
php-fpm -D

# Start nginx in foreground (keeps container alive)
exec nginx -g 'daemon off;'
