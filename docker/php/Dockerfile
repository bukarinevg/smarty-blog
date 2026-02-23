FROM php:8.4-fpm

RUN apt-get update \
    && apt-get install -y git unzip libzip-dev curl ca-certificates \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql \
    && npm install -g npm@latest \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN mkdir -p /var/www/html/var/smarty/templates_c /var/www/html/var/smarty/cache \
    && chown -R www-data:www-data /var/www/html/var \
    && chmod -R 775 /var/www/html/var
