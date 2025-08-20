# ---------- Stage 1: Builder ----------
FROM php:8.3-fpm-alpine AS builder

# Installer les extensions PHP nécessaires pour Symfony
RUN apk --no-cache add curl git unzip \
    && curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
       -o /usr/local/bin/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions opcache intl pdo pdo_pgsql zip gd

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /app

# Copier les fichiers de dépendances
COPY composer.json composer.lock symfony.lock ./

# Installer les dépendances (sans les scripts pour éviter les problèmes)
RUN composer install --no-dev --no-autoloader --no-interaction --no-scripts

# Copier le reste de l'application
COPY . .

# Exécuter les scripts Composer et optimiser l'autoloader
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

# ---------- Stage 2: Production ----------
FROM php:8.3-fpm-alpine

# Installer les extensions PHP et les paquets nécessaires
RUN apk --no-cache add nginx supervisor bash \
    && curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
       -o /usr/local/bin/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions opcache intl pdo pdo_pgsql zip gd

# Créer les répertoires nécessaires
RUN mkdir -p /var/run/php /var/log/nginx /var/cache/nginx /var/www/html \
    && chown -R www-data:www-data /var/run/php /var/www/html \
    && chown -R nginx:nginx /var/log/nginx /var/cache/nginx

WORKDIR /var/www/html

# Copier l'application depuis le stage builder
COPY --from=builder --chown=www-data:www-data /app .

# Vérifier que le répertoire vendor existe
RUN echo "Contenu du répertoire vendor:" && ls -la vendor/ && \
    echo "Vérification de l'autoloader:" && ls -la vendor/autoload.php

# Copier les configurations
COPY docker/render/default.conf /etc/nginx/conf.d/default.conf
COPY docker/render/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/render/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/render/nginx.conf /etc/nginx/nginx.conf

# Script d'entrée pour Symfony
COPY docker/render/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Variables d'environnement pour Symfony
ENV APP_ENV=prod
ENV APP_DEBUG=0

EXPOSE 8080

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]