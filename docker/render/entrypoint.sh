#!/bin/sh
set -e

echo "▶️ Lancement des commandes Symfony..."
php bin/console assets:install --symlink --relative --env=prod || true
php bin/console cache:clear --env=prod || true

echo "▶️ Lancement de supervisord..."
exec "$@"
