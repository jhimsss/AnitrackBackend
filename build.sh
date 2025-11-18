#!/bin/bash

# Install dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Generate application key if not exists
if [ ! -f ".env" ]; then
    cp .env.example .env
fi

php artisan key:generate

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (optional - you might want to do this manually)
# php artisan migrate --force