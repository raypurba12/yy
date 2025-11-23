#!/bin/bash
# Build script for Railway deployment

echo "Starting build process..."

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Build frontend assets
npm install
npm run build

# Generate application key if it doesn't exist
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY not found, generating one..."
    php artisan key:generate --force
fi

# Cache configuration for better performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build process completed!"