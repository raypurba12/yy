#!/bin/bash
# Build script for Railway deployment

echo "Starting build process..."

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Clear any previous caches that might be corrupted
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Build frontend assets
npm install
npm run build

# Generate application key if it doesn't exist
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY not found, generating one..."
    php artisan key:generate --force
fi

# Cache configuration for better performance (only after ensuring dependencies are loaded properly)
php artisan config:cache
php artisan route:cache
# Skip view:cache if there are issues with policies or auth services
# php artisan view:cache

echo "Build process completed!"