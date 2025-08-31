#!/bin/sh
set -e

echo "▶Installation des assets..."
php bin/console assets:install --symlink --relative --env=prod || true
php bin/console cache:clear --env=prod || true

MERCURE_CONFIG_DIR="/var/www/html/mercure/.config"
mkdir -p $MERCURE_CONFIG_DIR

export MERCURE_PUBLISHER_JWT_KEY="a-string-secret-at-least-256-bits-long"
export MERCURE_SUBSCRIBER_JWT_KEY="a-string-secret-at-least-256-bits-long"
export MERCURE_ALLOWED_ORIGINS="*"

# On s'assure que le binaire est exécutable
chmod +x /var/www/html/mercure/mercure

echo "▶ Démarrage de supervisord..."
exec "$@"
