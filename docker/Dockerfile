FROM php:8.4-fpm-alpine3.20

# Installer les dépendances nécessaires
RUN apk add --no-cache bash curl git unzip icu-dev libzip-dev oniguruma-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring zip intl

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

CMD ["php-fpm"]
