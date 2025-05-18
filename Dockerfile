# Dockerfile for Laravel on Render

FROM php:8.0-fpm

WORKDIR /var/www

# 1) System deps
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip git \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install gd zip

# 2) Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

        RUN mkdir -p storage bootstrap/cache \
        && chown -R www-data:www-data storage bootstrap/cache


# 3) Copy app & install PHP deps
COPY . .
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# 4) Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# 5) Expose the port Render sets (just documentation—Render injects $PORT)
EXPOSE 8000

# 6) Start the built-in server on $PORT (fallback to 8000)
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
