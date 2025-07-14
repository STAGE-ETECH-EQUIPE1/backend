FROM php:8.3-cli

RUN apt-get update && apt-get upgrade -y

RUN apt-get update && apt-get install -y \
    git unzip zip libicu-dev libonig-dev libpq-dev libzip-dev curl \
    && docker-php-ext-install intl mbstring pdo pdo_pgsql zip opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copier tout le code (sauf vendor via .dockerignore)
COPY . .

# Installer les dépendances (exclure dev en prod)
RUN composer install --prefer-dist --no-scripts --no-interaction --optimize-autoloader

# Générer l’autoload optimisé, notamment autoload_runtime.php
RUN composer dump-autoload --optimize

RUN mkdir -p var/cache var/log && chmod -R 777 var

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
