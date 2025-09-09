# ---------- Stage 1 : build dependencies ----------
FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./

# Installer les dépendances sans scripts (pas besoin de bin/console ici)
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-dev --prefer-dist --optimize-autoloader --no-scripts

# ---------- Stage 2 : final image ----------

FROM php:8.2-fpm-alpine
# Installer utilitaires + supervisor + nginx
RUN apk --no-cache add curl wget bash dpkg supervisor nginx

# --------------------------------------------------------------------
# PHP Extensions
# --------------------------------------------------------------------
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

RUN mkdir -p /var/www/html/public/generated-ai/logo \
    && chown -R root:root /var/www/html/public/generated-ai \
    && chmod -R 777 /var/www/html/public/generated-ai/logo/

RUN id www-data

COPY docker/render/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/render/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/render/php/php-fpm.conf /etc/php/php-fpm.d/www.conf
COPY docker/render/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY docker/render/supervisor/symfony_messenger.conf /etc/supervisor/conf.d/symfony_messenger.conf
COPY docker/render/supervisor/php_supervisor.conf /etc/supervisor/conf.d/php_supervisor.conf
COPY docker/render/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]


# Variables d'environnement prod
ENV APP_ENV=prod
ENV APP_DEBUG=0
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PORT=8080
EXPOSE 8080

# Démarrage via supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
