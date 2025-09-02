#!/bin/bash

set -e

cd /var/www/html

echo "Project contents:"
ls -la

echo "▶ Installing project dependencies..."

php bin/console assets:install --env=prod || true

php bin/console messenger:stop-workers
php bin/console cache:pool:clear cache.global_clearer
php bin/console cache:clear --env=prod || true

echo "▶Démarrage de supervisord..."
exec "$@"
