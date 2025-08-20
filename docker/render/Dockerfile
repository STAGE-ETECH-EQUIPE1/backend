FROM php:8.3-fpm-alpine

# Extensions PHP
RUN apk --no-cache add curl git bash nginx supervisor \
    && curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
       -o /usr/local/bin/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions opcache pdo pdo_pgsql pgsql zip intl gd redis fileinfo apcu

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /var/www/html

# Copier tout le projet et installer les dépendances
COPY . .

ENV APP_ENV=prod
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Configs Nginx & supervisord
COPY docker/render/default.conf /etc/nginx/conf.d/default.conf
COPY docker/render/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/render/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/render/nginx.conf /etc/nginx/nginx.conf

ENV PORT=8080
EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
