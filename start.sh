#!/bin/bash
set -e

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Seed database
php artisan db:seed-safe || echo "Skipping seed, already done"

# Create storage link
php artisan storage:link --force

# Start web server on PORT environment variable
php artisan serve --host=0.0.0.0 --port=$PORT