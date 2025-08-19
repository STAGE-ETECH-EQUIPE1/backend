FROM php:8.3-fpm-alpine

RUN apk --no-cache add curl git wget bash dpkg

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions opcache iconv soap zip intl fileinfo
RUN install-php-extensions pdo redis pgsql pdo_pgsql gd apcu

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /var/www/html


FROM nginx:1.29.0-alpine

COPY ./default.conf /etc/nginx/conf.d/default.conf

COPY --from=php /var/www/html /var/www/html

ENV PORT=8080
EXPOSE 8080

CMD ["nginx", "-g", "daemon off;"]
