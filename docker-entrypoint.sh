#!/bin/sh

set -e

echo "🔁 Waiting for MySQL..."
while ! mysqladmin ping -h"crm-mysql" --silent; do
  sleep 1
done

echo "📦 Installing Composer dependencies..."
composer install --no-interaction --prefer-dist

echo "📦 Installing NPM packages..."
npm install --legacy-peer-deps

echo "🔨 Building frontend..."
npm run build

echo "🔑 Generating app key..."
php artisan key:generate

echo "🧱 Running migrations..."
php artisan migrate --force

echo "🔗 Linking storage..."
php artisan storage:link || true

echo "✅ Application is ready at https://crm.localhost"

exec php artisan serve \
  --host=0.0.0.0 \
  --port=8000 \
  --tls \
  --cert=/etc/ssl/local/crm.localhost.crt \
  --key=/etc/ssl/local/crm.localhost.key
