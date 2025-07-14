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

# Copie des fichiers Composer pour optimiser le cache Docker
COPY composer.json composer.lock ./

# Installation des dépendances AVEC exécution des scripts
RUN composer install --prefer-dist --no-interaction --optimize-autoloader

# Copie du reste de l'application
COPY . .

# Configuration des permissions et génération du cache
RUN mkdir -p var/cache var/log \
    && chmod -R 777 var \
    && php bin/console cache:warmup --env=prod

# Exposition du port
EXPOSE 8000

# Commande de démarrage
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]