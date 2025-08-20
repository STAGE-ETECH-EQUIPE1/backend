# ---------- Stage 1: PHP + Composer ----------
FROM php:8.3-fpm-alpine AS php

# Extensions PHP nécessaires
RUN apk --no-cache add curl git wget bash dpkg \
    && curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    -o /usr/local/bin/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions opcache iconv soap zip intl fileinfo \
    && install-php-extensions pdo redis pgsql pdo_pgsql gd apcu

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Dossier de travail
WORKDIR /var/www/html

# Copier seulement les fichiers composer pour cacher le cache Docker
COPY composer.json composer.lock ./
ENV APP_ENV=prod
RUN composer install --prefer-dist --no-scripts --no-interaction --optimize-autoloader
# Copier le reste du projet
COPY . .

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Installer Nginx et supervisor
RUN apk --no-cache add supervisor nginx bash

# Créer les dossiers nécessaires
RUN mkdir -p /var/run/php /var/log/nginx /var/cache/nginx /var/www/html \
    && chown -R www-data:www-data /var/run/php /var/www/html \
    && chown -R nginx:nginx /var/log/nginx /var/cache/nginx

# Copier le projet et vendor depuis le stage PHP
COPY --from=php /var/www/html /var/www/html

RUN ls -l /var/www/html/vendor/autoload_runtime.php || echo "❌ Fichier manquant dans /var/www/html/vendor/"

# Copier les configs
COPY docker/render/default.conf /etc/nginx/conf.d/default.conf
COPY docker/render/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/render/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/render/nginx.conf /etc/nginx/nginx.conf

# Rediriger PHP-FPM logs vers stdout/stderr
RUN sed -i 's|access.log =.*|access.log = /proc/self/fd/1|' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's|error_log =.*|error_log = /proc/self/fd/2|' /usr/local/etc/php-fpm.d/www.conf

# Ports exposés
ENV PORT=8080
EXPOSE 8080

# Commande de démarrage
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
