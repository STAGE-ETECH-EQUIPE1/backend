#!/bin/sh
set -e

echo "▶️ Installation des assets..."
php bin/console assets:install --symlink --relative --env=prod || true
php bin/console cache:clear --env=prod || true

echo "▶️ Démarrage de supervisord..."
exec "$@"
