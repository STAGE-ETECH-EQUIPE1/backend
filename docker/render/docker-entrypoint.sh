#!/bin/sh
set -e

cd /var/www/html

# Vérifier si le répertoire vendor existe
if [ ! -d "vendor" ]; then
    echo "Installation des dépendances Composer..."
    composer install --no-dev --optimize-autoloader --no-interaction
fi

# Exécuter les migrations de base de données si nécessaire
# php bin/console doctrine:migrations:migrate --no-interaction

# Vider le cache Symfony
echo "Vidage du cache Symfony..."
php bin/console cache:clear --env=prod --no-debug
php bin/console cache:warmup --env=prod --no-debug

# Définir les permissions
chown -R www-data:www-data var

exec "$@"