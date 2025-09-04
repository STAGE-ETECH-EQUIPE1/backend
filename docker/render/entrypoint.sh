#!/bin/bash
set -e

cd /var/www/html

echo "▶ Project contents:"
ls -la

echo "▶ Installing project assets..."
php bin/console assets:install --env=prod || true

echo "▶ Stopping old Messenger workers..."
php bin/console messenger:stop-workers || true

echo "▶ Clearing cache..."
php bin/console cache:pool:clear cache.global_clearer || true
php bin/console cache:clear --env=prod || true

# Wait for PostgreSQL to be ready
echo "▶ Waiting for database..."
until php bin/console doctrine:query:sql "SELECT 1" >/dev/null 2>&1; do
    echo "Waiting for database..."
    sleep 1
done

echo "Database is ready!"

echo "▶ Ensuring database & migrations..."
php bin/console doctrine:database:create --if-not-exists || true
php bin/console doctrine:migrations:migrate --no-interaction || true
php bin/console doctrine:schema:update --force || true

echo "▶ Starting supervisord..."
exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
