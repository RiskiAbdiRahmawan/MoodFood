#!/bin/bash

# Railway Deployment Script for MoodFood Laravel App
# This script handles the deployment and setup process

echo "🚀 Starting Railway deployment..."

# Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "📦 Installing NPM dependencies..."
npm ci

# Build assets
echo "🔨 Building frontend assets..."
npm run build

# Laravel optimizations
echo "⚡ Optimizing Laravel application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Database setup
echo "🗄️  Setting up database..."
php artisan migrate --force

# Check if database is empty and seed if necessary
TABLES=$(php artisan tinker --execute="echo count(array_filter(array_map(function(\$table) { return \$table !== 'migrations'; }, Schema::getTableListing())));")
if [ "$TABLES" -le 1 ]; then
    echo "🌱 Seeding database with initial data..."
    php artisan db:seed --force
fi

# Storage link
echo "🔗 Creating storage link..."
php artisan storage:link --force

echo "✅ Deployment completed successfully!"
