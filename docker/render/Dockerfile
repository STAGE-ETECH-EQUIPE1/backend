# ---------- Stage 1 : build dependencies ----------
FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./
# skip cache clear, pas besoin du code source pour installer vendor
RUN COMPOSER_ALLOW_SUPERUSER=1 SYMFONY_SKIP_CACHE=1 composer install --no-dev --prefer-dist --optimize-autoloader

# ---------- Stage 2 : final image ----------
FROM php:8.3-fpm-alpine

# Installer dépendances système
RUN apk --no-cache add curl git wget bash dpkg supervisor nginx \
    && curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    -o /usr/local/bin/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions opcache iconv soap zip intl fileinfo \
    && install-php-extensions pdo redis pgsql pdo_pgsql gd apcu

# Préparer les dossiers
RUN mkdir -p /var/run/php /var/log/nginx /var/cache/nginx /var/www/html \
    && chown -R www-data:www-data /var/run/php /var/www/html \
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

# Rediriger PHP-FPM logs vers stdout/stderr
RUN sed -i 's|access.log =.*|access.log = /proc/self/fd/1|' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's|error_log =.*|error_log = /proc/self/fd/2|' /usr/local/etc/php-fpm.d/www.conf

# Vérifier vendor/autoload_runtime.php
RUN test -f vendor/autoload_runtime.php || (echo "❌ autoload_runtime.php manquant" && exit 1)

# Ports exposés
ENV APP_ENV=prod
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PORT=8080
EXPOSE 8080

# Commande de démarrage
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
