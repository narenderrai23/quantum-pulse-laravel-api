#!/bin/sh

DB_HOST="${DB_HOST:-127.0.0.1}"
DB_PORT="${DB_PORT:-3306}"

echo "Waiting for MySQL at $DB_HOST:$DB_PORT..."
until nc -z "$DB_HOST" "$DB_PORT" 2>/dev/null; do
  echo "MySQL not ready yet, retrying in 3s..."
  sleep 3
done

echo "MySQL is ready. Running migrations..."
php /var/www/html/artisan migrate --force --no-interaction
php /var/www/html/artisan db:seed --class=AdminSeeder --force --no-interaction
php /var/www/html/artisan db:seed --class=SettingSeeder --force --no-interaction
php /var/www/html/artisan optimize
echo "Laravel setup complete."
