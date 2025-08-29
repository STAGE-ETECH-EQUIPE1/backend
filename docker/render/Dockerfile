# --------------------------------------------------------------------
# Dockerfile for Render
# --------------------------------------------------------------------
FROM php:8.3-fpm-alpine

ENV APP_ENV=prod
ENV APP_DEBUG=0

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
RUN mkdir -p /var/run /var/run/mercure /var/run/nginx \
    && mkdir -p /var/log/nginx /var/log/supervisor /var/tmp/nginx \
    && mkdir -p /etc/mercure \
    && chown -R www-data:www-data /var/run/mercure /var/www /var/tmp/nginx /etc/mercure \
    && chmod -R 755 /var/www \
    && chown -R nginx:nginx /var/log/nginx /var/tmp/nginx /var/run/nginx
# --------------------------------------------------------------------

# --------------------------------------------------------------------
# Configuration files for Nginx Server
# --------------------------------------------------------------------
COPY docker/render/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/render/nginx/default.conf /etc/nginx/conf.d/default.conf
# --------------------------------------------------------------------

# --------------------------------------------------------------------
# Composer
# --------------------------------------------------------------------
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts
# --------------------------------------------------------------------

# --------------------------------------------------------------------
# Mercure
# --------------------------------------------------------------------
# Configuration file for mercure to run mercure
COPY docker/render/mercure/dev.Caddyfile /etc/mercure/dev.Caddyfile
COPY docker/render/mercure/Caddyfile /etc/mercure/Caddyfile
RUN wget https://github.com/dunglas/mercure/releases/download/v0.20.2/mercure_Linux_x86_64.tar.gz \
    && tar xvf mercure_Linux_x86_64.tar.gz \
    && mv mercure /usr/local/bin/mercure \
    && rm mercure_Linux_x86_64.tar.gz
# --------------------------------------------------------------------

# --------------------------------------------------------------------
# Configuration files for Supervisor
# --------------------------------------------------------------------
COPY docker/render/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY docker/render/supervisor/symfony_messenger.conf /etc/supervisor/conf.d/symfony_messenger.conf
COPY docker/render/supervisor/mercure.conf /etc/supervisor/conf.d/mercure.conf
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
