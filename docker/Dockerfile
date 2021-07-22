FROM php:8.0-apache
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    vim \
    && docker-php-ext-install pdo_mysql

# change Document Root and enable mod_rewrite of Apache
RUN sed -i 's!/var/www/html!/var/www/laravel/public!g' /etc/apache2/sites-available/000-default.conf \
    && a2enmod rewrite

# node command
COPY --from=node /usr/local/bin /usr/local/bin
# npm command
COPY --from=node /usr/local/lib /usr/local/lib
# yarn command
COPY --from=node /opt /opt
