# Dockerfile for Laravel on Render

# 1) Base PHP image
FROM php:8.0-fpm

# 2) Set working directory
WORKDIR /var/www

# 3) Install system dependencies & PHP extensions
RUN apt-get update \
 && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install \
    gd \
    zip \
    pdo \
    pdo_mysql \
 && rm -rf /var/lib/apt/lists/*

# 4) Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5) Copy application files
COPY . .

# 6) Ensure storage & cache directories exist
RUN mkdir -p storage bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache

# 7) Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# 8) Final perms
RUN chown -R www-data:www-data /var/www \
 && chmod -R 775 storage bootstrap/cache

# 9) Expose PHP-FPM port
EXPOSE 9000

# 10) Run PHP-FPM
CMD ["php-fpm"]
