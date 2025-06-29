#!/bin/bash

# Wait for DB to be ready
echo "Waiting for MySQL to start..."
until php -r "try{new PDO('mysql:host=db;dbname=moodfood', 'root', 'root');}catch(\Exception \$e){exit(1);}" >/dev/null 2>&1; do
  echo -n "."
  sleep 1
done

cd /var/www

# Install dependencies
composer install --optimize-autoloader --no-interaction --no-progress

# Prepare Laravel application
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations and seeds
php artisan migrate
php artisan db:seed-safe

# Fix permissions
chown -R www:www /var/www/storage
chmod -R 775 /var/www/storage

exec "$@"
