FROM php:8.3-fpm-alpine AS php

RUN apk --no-cache add curl git wget bash dpkg

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions opcache iconv soap zip intl fileinfo \
    && install-php-extensions pdo redis pgsql pdo_pgsql gd apcu

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /var/www/html

# Cache composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copie tout le projet
COPY . .

FROM nginx:1.29.0-alpine

RUN apk add --no-cache supervisor php83-fpm

# Création des users
RUN if ! getent group www-data >/dev/null 2>&1; then \
    addgroup -g 1000 -S www-data; \
    fi && \
    if ! id -u www-data >/dev/null 2>&1; then \
    adduser -u 1000 -S www-data -G www-data; \
    fi

RUN adduser nginx www-data

RUN mkdir -p /var/run/php /var/log/nginx /var/cache/nginx /var/log/php83 \
    && chown -R www-data:www-data /var/run/php /var/log/php83 \
    && chown -R nginx:nginx /var/log/nginx /var/cache/nginx \
    && chmod -R 775 /var/run/php /var/log/nginx /var/cache/nginx /var/log/php83

RUN sed -i '/user  nginx;/d' /etc/nginx/nginx.conf

COPY docker/render/php-fpm.conf /etc/php83/php-fpm.d/www.conf
COPY docker/render/default.conf /etc/nginx/conf.d/default.conf
COPY docker/render/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copie des fichiers Symfony
COPY --from=php /var/www/html /var/www/html

RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

ENV PORT=8080
EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
