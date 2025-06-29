# Use PHP 8.2 with FPM
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    default-mysql-client

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:2.6.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
RUN npm ci && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Remove any existing symlink and create a fresh one
RUN rm -f /var/www/html/public/storage \
    && ln -s /var/www/html/storage/app/public /var/www/html/public/storage

# Create startup script
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
# Run Laravel setup\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
php artisan migrate --force\n\
php artisan db:seed-safe\n\
php artisan storage:link --force\n\
\n\
# Start PHP-FPM\n\
php-fpm' > /start.sh && chmod +x /start.sh

# Expose port 9000
EXPOSE 9000

# Start PHP-FPM
CMD ["/start.sh"]
