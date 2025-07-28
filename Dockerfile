FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libonig-dev \
    libpq-dev \
    libzip-dev \
    curl \
    && docker-php-ext-install intl mbstring pdo pdo_pgsql zip opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --prefer-dist --no-scripts --no-interaction --optimize-autoloader

COPY . .

RUN composer dump-autoload --optimize

RUN mkdir -p var/cache var/log && chmod -R 777 var

RUN php bin/console cache:clear --env=dev --no-debug || true

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
