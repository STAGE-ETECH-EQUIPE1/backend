# Étape 1 : image PHP avec extensions utiles pour Symfony
FROM php:8.3-cli

# Mise à jour des paquets et installation des dépendances
RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libonig-dev \
    libpq-dev \
    libzip-dev \
    curl \
    && docker-php-ext-install intl mbstring pdo pdo_pgsql zip opcache

# Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Répertoire de travail
WORKDIR /app

# Autoriser Composer à s'exécuter en tant que super-utilisateur
ENV COMPOSER_ALLOW_SUPERUSER=1

# 1. Copier uniquement les fichiers Composer
COPY composer.json composer.lock ./

# 2. Installer les dépendances SANS exécuter les scripts
RUN composer install --prefer-dist --no-scripts --no-interaction --optimize-autoloader

# 3. Copier le reste de l'application
COPY . .

# 4. Installer les binaires Symfony manuellement
RUN ./vendor/bin/symfony_requirements

# 5. Exécuter les scripts Composer manuellement
RUN ./vendor/bin/simple-phpunit install && composer run-script post-install-cmd

# Configuration des permissions
RUN mkdir -p var/cache var/log \
    && chmod -R 777 var

# Pré-chauffage du cache
RUN php bin/console cache:warmup --env=prod

# Exposition du port
EXPOSE 8000

# Commande de démarrage
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]