FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install zip pdo_mysql gd

RUN a2enmod rewrite

COPY . .

COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-interaction --ignore-platform-req=ext-gd || \
    (composer require maatwebsite/excel:^3.1 && composer install --no-interaction)

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

EXPOSE 80
CMD ["apache2-foreground"]
