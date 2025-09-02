#!/bin/bash

set -e

cd /var/www/html

echo "Project contents:"
ls -la

echo "▶ Installing project dependencies..."

php bin/console assets:install --env=prod || true

# --------------------------------------------------------------------
# JWT Key pem for jwt auth token
# --------------------------------------------------------------------
JWT_DIR="/var/www/html/config/jwt"
if [ ! -f "$JWT_DIR/private.pem" ] || [ ! -f "$JWT_DIR/public.pem" ]; then
    echo "Generating JWT keypair..."
    php bin/console lexik:jwt:generate-keypair --no-interaction
    if [ -f "$JWT_DIR/private.pem" ] && [ -f "$JWT_DIR/public.pem" ]; then
        chmod 644 "$JWT_DIR/private.pem" "$JWT_DIR/public.pem"
        chown www-data:www-data "$JWT_DIR/private.pem" "$JWT_DIR/public.pem"
        echo "JWT keys generated with proper permissions"
    else
        echo "❌ Failed to generate JWT keypair!"
    fi
else
    echo "JWT keys already exist, skipping generation"
fi
# --------------------------------------------------------------------

php bin/console messenger:stop-workers
php bin/console cache:pool:clear cache.global_clearer
php bin/console cache:clear --env=prod || true

# Création dossier Mercure accessible par www-data
MERCURE_CONFIG_DIR="/var/www/html/mercure/.config"
mkdir -p $MERCURE_CONFIG_DIR
chmod -R 755 $MERCURE_CONFIG_DIR

# On s'assure que le binaire est exécutable
chmod +x /var/www/html/mercure/mercure

echo "▶Démarrage de supervisord..."
exec "$@"
