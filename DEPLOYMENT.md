# Deployment Notes for Railway

## Current Issues and Fixes Applied:

1. Created Procfile to specify the start command for Railway
2. Updated composer.json to run migrations after installation
3. Created a deployment helper script

## CRITICAL ISSUE: SQLite on Railway

Your application currently uses SQLite as the default database, which will NOT work properly on Railway due to ephemeral storage. Each deployment or restart will wipe your database file.

### Recommended Solutions:
1. **Switch to PostgreSQL** (recommended):
   - Add Railway's PostgreSQL addon to your project
   - Update environment variables to use PostgreSQL

2. **If staying with SQLite** (not recommended):
   - Data will be lost on every deployment/restart
   - You'll need to reseed data each time

## For Railway Deployment:

1. Make sure you have the following environment variables set in Railway:
   - APP_KEY (generate with `php artisan key:generate --show`)
   - DB_CONNECTION=pgsql (for PostgreSQL) or sqlite (not recommended)
   - If using PostgreSQL, the DATABASE_URL will be auto-provided by Railway

2. The application is configured to run on production with:
   - APP_ENV=production
   - APP_DEBUG=false

3. The start command in Procfile is:
   web: php artisan serve --host=0.0.0.0 --port=$PORT

## Important Notes:

- SQLite files on Railway are ephemeral (disappear after each deployment/restart)
- Strongly recommend using PostgreSQL for persistent data storage
- If you want to use SQLite, data will be lost on every restart

## To generate APP_KEY:
1. Locally run: php artisan key:generate --show
2. Copy the value to the APP_KEY environment variable in Railway