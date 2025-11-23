#!/bin/bash
# Post-deployment script for Railway

echo "Starting post-deployment setup..."

# Ensure storage and bootstrap/cache directories are writable
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
else
    echo "Using provided APP_KEY"
fi

# Clear any cached configuration
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Seed the database if needed (uncomment the next line if you have seeders)
# php artisan db:seed --force

echo "Post-deployment setup completed!"