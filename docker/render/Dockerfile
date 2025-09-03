# --------------------------------------------------------------------
# Dockerfile for Render
# --------------------------------------------------------------------
FROM php:8.3-fpm-alpine

RUN apk --no-cache add curl wget bash dpkg supervisor vim nginx

# --------------------------------------------------------------------
# PHP Extensions
# --------------------------------------------------------------------
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions
RUN install-php-extensions opcache iconv soap zip intl fileinfo bcmath sockets tokenizer \
    && install-php-extensions pdo pgsql pdo_pgsql gd apcu openssl xml mbstring
COPY docker/render/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
# --------------------------------------------------------------------

# --------------------------------------------------------------------
# Copy application files
# --------------------------------------------------------------------
WORKDIR /var/www/html
COPY . .
# --------------------------------------------------------------------

# --------------------------------------------------------------------
# Create necessary directories
# --------------------------------------------------------------------
RUN mkdir -p /var/run /var/run/nginx \
    && mkdir -p /var/log/nginx /var/log/supervisor /var/tmp/nginx \
    && chown -R www-data:www-data /var/www /var/tmp/nginx \
    && chmod -R 755 /var/www \
    && chown -R nginx:nginx /var/log/nginx /var/tmp/nginx /var/run/nginx
# --------------------------------------------------------------------
# Composer
# --------------------------------------------------------------------
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
USER www-data
RUN APP_ENV=dev APP_DEBUG=0 composer install --no-interaction --optimize-autoloader
USER root
# --------------------------------------------------------------------
# Configuration files for Supervisor
# --------------------------------------------------------------------
COPY docker/render/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY docker/render/supervisor/symfony_messenger.conf /etc/supervisor/conf.d/symfony_messenger.conf
COPY docker/render/supervisor/nginx_supervisor.conf /etc/supervisor/conf.d/nginx_supervisor.conf
COPY docker/render/supervisor/php_supervisor.conf /etc/supervisor/conf.d/php_supervisor.conf
# --------------------------------------------------------------------

# --------------------------------------------------------------------
# Entrypoint to initialize project dependencies
# --------------------------------------------------------------------
COPY docker/render/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT [ "/entrypoint.sh" ]
# --------------------------------------------------------------------

EXPOSE 80

# Run Supervisor
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
