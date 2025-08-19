FROM php:8.3-fpm-alpine AS php

RUN apk --no-cache add curl git wget bash dpkg

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions opcache iconv soap zip intl fileinfo
RUN install-php-extensions pdo redis pgsql pdo_pgsql gd apcu

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /var/www/html

FROM nginx:1.29.0-alpine

RUN apk add --no-cache supervisor php83-fpm

RUN if ! getent group www-data >/dev/null 2>&1; then \
        addgroup -g 1000 -S www-data; \
    fi && \
    if ! id -u www-data >/dev/null 2>&1; then \
        adduser -u 1000 -S www-data -G www-data; \
    fi && \
    mkdir -p /var/run/php && \
    chown -R www-data:www-data /var/run/php && \
    chmod 775 /var/run/php

COPY docker/render/php-fpm.conf /etc/php83/php-fpm.d/www.conf
COPY docker/render/default.conf /etc/nginx/conf.d/default.conf
COPY docker/render/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN echo "=== VÉRIFICATION CONFIGURATION PHP-FPM ===" && \
    echo "Contenu de www.conf:" && \
    grep -E "(listen|user|group|pm\.)" /etc/php83/php-fpm.d/www.conf && \
    echo -e "\n=== VÉRIFICATION CONFIGURATION NGINX ===" && \
    echo "Directive fastcgi_pass:" && \
    grep "fastcgi_pass" /etc/nginx/conf.d/default.conf && \
    echo -e "\n=== VÉRIFICATION RÉPERTOIRES ===" && \
    echo "Permissions /var/run/php:" && \
    ls -la /var/run/ | grep php && \
    echo -e "\n=== VÉRIFICATION UTILISATEURS ===" && \
    echo "Utilisateur www-data:" && \
    id www-data && \
    echo "Groupe www-data:" && \
    getent group www-data

COPY --from=php /var/www/html /var/www/html

RUN chown -R www-data:www-data /var/www/html && \
    echo "=== VÉRIFICATION PERMISSIONS APPLICATION ===" && \
    ls -la /var/www/html/

ENV PORT=8080
EXPOSE 8080

RUN nginx -t

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]