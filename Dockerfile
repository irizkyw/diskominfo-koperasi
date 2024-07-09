FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo_mysql

RUN a2enmod rewrite

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-interaction

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

EXPOSE 80
CMD ["apache2-foreground"]
