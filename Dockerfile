FROM php:8.2-cli as php

RUN apt-get update -y \
    && apt-get install -y unzip libpq-dev libcurl4-gnutls-dev git \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

WORKDIR /var/www/html
COPY . .

COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

RUN composer install --no-progress --no-interaction

EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80"]
