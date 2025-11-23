<?php
// Deployment script for Railway

// Check if running on Railway
if (getenv('RAILWAY_DEPLOY')) {
    // Set production environment
    $_ENV['APP_ENV'] = 'production';
    $_ENV['APP_DEBUG'] = 'false';
    
    // Use database from Railway environment variables
    if (getenv('DATABASE_URL')) {
        // Parse DATABASE_URL for PostgreSQL/MySQL
        $url = parse_url(getenv('DATABASE_URL'));
        $_ENV['DB_HOST'] = $url['host'];
        $_ENV['DB_PORT'] = $url['port'];
        $_ENV['DB_DATABASE'] = ltrim($url['path'], '/');
        $_ENV['DB_USERNAME'] = $url['user'];
        $_ENV['DB_PASSWORD'] = $url['pass'];
    }
}

// Run migrations if environment is production
if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'production') {
    echo "Running migrations...\n";
    exec('php artisan migrate --force');
}