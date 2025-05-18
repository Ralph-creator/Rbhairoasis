FROM php:8.2-fpm

# 1) System deps + PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd \
 && rm -rf /var/lib/apt/lists/*

# 2) Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3) Set workdir
WORKDIR /var/www/html

# 4) Copy composer files + make dirs
COPY composer.json composer.lock ./
RUN mkdir -p bootstrap/cache storage \
 && chmod -R 775 bootstrap/cache storage

# 5) Install PHP deps WITHOUT scripts
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-scripts

# 6) Copy rest of app & env.example
COPY .env.example .env
COPY . .

# 7) Now that .env is present, run package discovery
RUN composer run-script post-autoload-dump

# 8) Set perms
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
