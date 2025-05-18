FROM php:8.2-fpm

# 1) PHP extensions…
RUN apt-get update && apt-get install -y \
    … \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

# 2) Work here
WORKDIR /var/www/html

# 3) Bring in Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4) Copy your app
COPY . /var/www/html

# 5) Fix perms
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000
CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000","--public","public"]
