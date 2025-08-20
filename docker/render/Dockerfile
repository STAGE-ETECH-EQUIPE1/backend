FROM php:8.3-fpm-alpine

# Extensions PHP
RUN apk --no-cache add curl git wget bash dpkg supervisor nginx \
    && curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    -o /usr/local/bin/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions opcache iconv soap zip intl fileinfo \
    && install-php-extensions pdo redis pgsql pdo_pgsql gd apcu

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Création des dossiers pour PHP + Nginx
RUN mkdir -p /var/run/php /var/log/nginx /var/cache/nginx /var/www/html \
    && chown -R www-data:www-data /var/run/php /var/www/html \
    && chown -R nginx:nginx /var/log/nginx /var/cache/nginx

WORKDIR /var/www/html

# Symfony
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts
COPY . .

RUN chown -R www-data:www-data /var/www/html

# Configs
COPY docker/render/default.conf /etc/nginx/conf.d/default.conf
COPY docker/render/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/render/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

ENV PORT=8080
EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
