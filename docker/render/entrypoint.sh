#!/bin/bash
set -e

cd /var/www/html

echo "▶ Project contents:"
ls -la

echo "▶ Permission Folders..."
sudo chown -R www-data:www-data public/generated-ai
sudo chmod -R 775 public/generated-ai

echo "▶ Logo Generation Folder Permission :"
ls -la /var/www/html/public/generated-ai/logo

echo "▶ Installing project assets..."
php bin/console assets:install --env=prod || true

echo "▶ Clearing cache..."
php bin/console cache:pool:clear cache.global_clearer || true
php bin/console cache:clear --env=prod || true

# Wait for database to be ready
echo "▶ Waiting for database..."
until php bin/console doctrine:query:sql "SELECT 1" >/dev/null 2>&1; do
    echo "Waiting for database..."
    sleep 1
done
echo "Database is ready!"

echo "▶ Generating KeyPair..."
php bin/console lexik:jwt:generate-keypair --overwrite --no-interaction

echo "▶ Ensuring database & migrations..."
php bin/console doctrine:database:create --if-not-exists || true
php bin/console doctrine:migrations:migrate --no-interaction || true
php bin/console doctrine:schema:update --force || true

echo "▶ Starting supervisord..."
exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
