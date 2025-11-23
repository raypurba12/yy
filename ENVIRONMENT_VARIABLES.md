# Environment Variables Required for Railway Deployment

## Mandatory Environment Variables:

APP_KEY=your_app_key_here
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=sqlite  # or mysql/postgres if using those

## If using MySQL/PostgreSQL, also set:
# DB_HOST=your_db_host
# DB_PORT=your_db_port  
# DB_DATABASE=your_db_name
# DB_USERNAME=your_db_username
# DB_PASSWORD=your_db_password

## If using Railway's Database addon:
# DATABASE_URL=auto-provided by Railway (for PostgreSQL/MySQL)

## Optional but recommended:
LOG_CHANNEL=stderr
LOG_LEVEL=info

---

## How to generate APP_KEY:
1. Locally, run: php artisan key:generate --show
2. Copy the output and set it as the APP_KEY environment variable in Railway

## For database configuration:
- For persistent storage, it's recommended to use Railway's PostgreSQL addon instead of SQLite
- If using SQLite, data will be lost on each deployment/restart since Railway has ephemeral storage