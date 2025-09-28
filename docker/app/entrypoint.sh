#!/usr/bin/env sh
set -e

# Ensure runtime directories exist
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache || true

# Fix permissions for mounted volumes
chown -R www-data:www-data storage || true
chown -R www-data:www-data bootstrap/cache || true

if [ -n "$DB_HOST" ]; then
  echo "Waiting for database $DB_HOST:${DB_PORT:-5432}..."
  TIMEOUT=30
  while ! nc -z "$DB_HOST" "${DB_PORT:-5432}" >/dev/null 2>&1; do
    TIMEOUT=$((TIMEOUT-1))
    if [ $TIMEOUT -le 0 ]; then
      echo "Database not reachable, continuing..."
      break
    fi
    sleep 1
  done
fi

# Clear any stale caches
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

# Rebuild package manifest and caches
php artisan package:discover --ansi || true

# Generate app key only if not provided and .env exists
if [ -z "$APP_KEY" ] && [ -f .env ]; then
  php artisan key:generate --force || true
fi

php artisan storage:link || true
php artisan migrate --force || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

exec "$@"
