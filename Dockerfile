# Étape 1 : image PHP avec extensions utiles pour Symfony
FROM php:8.3-cli

# Always update package lists and upgrade to latest security patches
RUN apt-get update && apt-get upgrade -y

# Installer les dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libonig-dev \
    libpq-dev \
    libzip-dev \
    curl \
    && docker-php-ext-install intl mbstring pdo pdo_pgsql zip opcache

# Installer Composer (version 2)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /app

# Copier uniquement les fichiers nécessaires pour installer les dépendances (pour profiter du cache Docker)
COPY composer.json composer.lock ./

# Installer les dépendances PHP sans les scripts (tu peux activer scripts si tu veux)
RUN composer install --prefer-dist --no-scripts --no-interaction --optimize-autoloader

# Copier tout le reste de l'application (code source, config, etc.)
COPY . .

# Donner les permissions nécessaires (cache, logs)
RUN mkdir -p var/cache var/log && chmod -R 777 var

# Exposer le port 8000 pour le serveur interne
EXPOSE 8000

# Lancer le serveur PHP intégré pointant vers le dossier public
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
