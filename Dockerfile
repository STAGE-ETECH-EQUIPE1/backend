# Image PHP avec extensions pour Symfony
FROM php:8.3-cli

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libonig-dev \
    libpq-dev \
    libzip-dev \
    curl \
    && docker-php-ext-install intl mbstring pdo pdo_pgsql zip opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configuration Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

# Répertoire de travail
WORKDIR /app

COPY .env .env

# Copie des fichiers de dépendances
COPY composer.json composer.lock ./

# Installation des dépendances sans scripts
RUN composer install --prefer-dist --no-scripts --no-interaction --optimize-autoloader

# Copie du code source
COPY . .

# Génération de l'autoloader optimisé
RUN composer dump-autoload --optimize

# Configuration des permissions
RUN mkdir -p var/cache var/log \
    && chmod -R 777 var

# Nettoyage du cache Symfony
RUN php bin/console cache:clear --env=prod --no-debug || true

# Exposition du port
EXPOSE 8000

# Commande de démarrage
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]