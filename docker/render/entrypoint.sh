#!/bin/sh
set -e

echo "▶️ Installation des assets..."
php bin/console assets:install --symlink --relative --env=prod || true

echo "▶️ Démarrage de supervisord..."
exec "$@"
