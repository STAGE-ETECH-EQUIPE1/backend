# Étape 1 : image PHP avec extensions utiles pour Symfony
FROM php:8.3-cli


# Always update package lists and upgrade to latest security patches
RUN apt-get update && apt-get upgrade -y

# Installer les dépendances système (ex : git, unzip, zip, etc.)
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

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Créer un répertoire pour l'application Symfony
WORKDIR /app

# Copier les fichiers de l'application
COPY . .

# Installer les dépendances PHP (avec --no-dev en prod si besoin)
RUN composer install --prefer-dist --no-scripts --no-interaction --optimize-autoloader

# Donner les permissions nécessaires
RUN mkdir -p var/cache var/log && chmod -R 777 var

# Port d’écoute si tu exposes un serveur interne (ex : Symfony server ou php -S)
EXPOSE 8000

# Lancer le serveur Symfony ou PHP
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
