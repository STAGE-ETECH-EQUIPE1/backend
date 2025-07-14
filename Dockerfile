# ----------------------------
# Étape 1 : Image PHP officielle + extensions Symfony
# ----------------------------
FROM php:8.3-cli

# Mise à jour et installation des dépendances système
RUN apt-get update && apt-get upgrade -y && \
    apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libonig-dev \
    libpq-dev \
    libzip-dev \
    curl \
    && docker-php-ext-install intl mbstring pdo pdo_pgsql zip opcache

# Installation de Composer depuis l'image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /app

# Variables d'environnement pour Composer (évite les warnings)
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    APP_ENV=prod \
    APP_DEBUG=0

# Copier uniquement les fichiers nécessaires pour installer les dépendances
COPY composer.json composer.lock symfony.lock ./

# Installation des dépendances PHP (avec scripts activés)
RUN composer install --prefer-dist --no-interaction --optimize-autoloader

# Copier le reste du code source
COPY . .

# Donner les bonnes permissions
RUN mkdir -p var/cache var/log && chmod -R 777 var

# Vérification des requirements Symfony (optionnel)
RUN php bin/console about

# Pré-chauffage du cache pour l'environnement de production
RUN php bin/console cache:warmup --env=prod

# Exposer le port (utilisé avec php -S)
EXPOSE 8000

# Commande de démarrage (serveur PHP intégré pointant vers /public)
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
