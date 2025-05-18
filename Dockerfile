FROM php:8.2-fpm

# -------------------------------------------------
# 1) System packages & PHP extensions
# -------------------------------------------------
RUN apt-get update && apt-get install -y \
    git unzip vim curl \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

# -------------------------------------------------
# 2) Set working directory
# -------------------------------------------------
WORKDIR /var/www

# -------------------------------------------------
# 3) Composer (copy from official image)
# -------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# -------------------------------------------------
# 4) Copy project code
# -------------------------------------------------
COPY . /var/www

# -------------------------------------------------
# 5) Correct ownership & permissions
#    (use /var/www, NOT /var/www/html)
# -------------------------------------------------
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# -------------------------------------------------
# 6) Expose port & start Laravel built-in server
# -------------------------------------------------
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000", "--public", "public"]
