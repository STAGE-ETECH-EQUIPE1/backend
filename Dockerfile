# Image PHP avec extensions pour Symfony
FROM php:8.3-cli

# Installation des dépendances système nécessaires
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

# Variables Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

# Répertoire de travail
WORKDIR /app

# Copier uniquement les fichiers nécessaires à composer install
COPY composer.json composer.lock ./

# Installer les dépendances PHP sans exécuter de script
RUN composer install --prefer-dist --no-scripts --no-interaction --optimize-autoloader

# Créer un fichier .env vide pour éviter l'erreur
RUN touch .env

# Copier le reste du code source
COPY . .

# Re-générer l’autoloader optimisé
RUN composer dump-autoload --optimize

# Préparer les répertoires nécessaires
RUN mkdir -p var/cache var/log && chmod -R 777 var

# Nettoyer le cache Symfony sans échouer si bin/console échoue
RUN php bin/console cache:clear --env=prod --no-debug || true

# Exposer le port par défaut
EXPOSE 8000

# Lancer le serveur PHP intégré
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
