# ---------- Stage 1 : build dependencies ----------
FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./

# Installer les dépendances sans scripts (pas besoin de bin/console ici)
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-dev --prefer-dist --optimize-autoloader --no-scripts

# ---------- Stage 2 : final image ----------
FROM php:8.3-fpm-alpine

# Installer dépendances système et extensions PHP
RUN apk --no-cache add curl git wget bash dpkg supervisor nginx \
    && curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    -o /usr/local/bin/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions opcache iconv soap zip intl fileinfo \
    && install-php-extensions pdo redis pgsql pdo_pgsql gd apcu

# Préparer les dossiers
RUN mkdir -p /var/run/php /var/log/nginx /var/cache/nginx /var/www/html /var/log/php83 \
    && chown -R www-data:www-data /var/run/php /var/www/html /var/log/php83 \
    && chown -R nginx:nginx /var/log/nginx /var/cache/nginx

WORKDIR /var/www/html

# Copier vendor depuis le stage build
COPY --from=vendor /app/vendor ./vendor

# Copier le reste du projet
COPY . .

# Copier les configs
COPY docker/render/default.conf /etc/nginx/conf.d/default.conf
COPY docker/render/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/render/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/render/nginx.conf /etc/nginx/nginx.conf

# Vérifier vendor/autoload_runtime.php
RUN test -f vendor/autoload_runtime.php
RUN php bin/console assets:install --symlink --relative --env=prod
RUN php bin/console cache:clear --env=prod

# Variables d'environnement prod
ENV APP_ENV=prod
ENV APP_DEBUG=0
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PORT=8080
EXPOSE 8080

# Démarrage via supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
