FROM php:8.3-fpm-alpine AS php

# Extensions
RUN apk --no-cache add curl git wget bash dpkg \
    && curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    -o /usr/local/bin/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions opcache iconv soap zip intl fileinfo \
    && install-php-extensions pdo redis pgsql pdo_pgsql gd apcu

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts
COPY . .

# ---------- Final Stage ----------
FROM nginx:1.29.0-alpine

RUN apk add --no-cache supervisor bash

# User setup
RUN addgroup -g 1000 -S www-data \
    && adduser -u 1000 -S www-data -G www-data \
    && adduser nginx www-data

RUN mkdir -p /var/run/php /var/log/nginx /var/cache/nginx \
    && chown -R www-data:www-data /var/run/php \
    && chown -R nginx:nginx /var/log/nginx /var/cache/nginx

# Configs
COPY docker/render/default.conf /etc/nginx/conf.d/default.conf
COPY docker/render/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/render/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# Copie de PHP + Symfony
COPY --from=php /usr/local /usr/local
COPY --from=php /var/www/html /var/www/html

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

ENV PORT=8080
EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
