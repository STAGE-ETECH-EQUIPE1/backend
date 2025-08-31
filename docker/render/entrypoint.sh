#!/bin/sh
set -e

echo "▶Installation des assets..."
php bin/console assets:install --symlink --relative --env=prod || true
php bin/console cache:clear --env=prod || true

# Création dossier Mercure accessible par www-data
MERCURE_CONFIG_DIR="/var/www/html/mercure/.config"
mkdir -p $MERCURE_CONFIG_DIR
chmod -R 755 $MERCURE_CONFIG_DIR

# On s'assure que le binaire est exécutable
chmod +x /var/www/html/mercure/mercure

echo "▶Démarrage de supervisord..."
exec "$@"
