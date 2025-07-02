#!/bin/sh

set -e

echo "🔁 Waiting for MySQL with Laravel..."
until php artisan migrate:status > /dev/null 2>&1; do
  sleep 1
done

echo "📦 Installing Composer dependencies..."
composer install --no-interaction --prefer-dist

echo "📦 Installing NPM packages..."
npm install --legacy-peer-deps

echo "⚡ Starting Vite dev server..."
npm run dev -- --host 0.0.0.0 &

echo "🔑 Generating app key..."
php artisan key:generate

echo "🧱 Running migrations..."
php artisan migrate --force

echo "🔗 Linking storage..."
php artisan storage:link || true

echo "✅ Application is ready at http://crm.localhost"

exec php artisan serve \
  --host=0.0.0.0 \
  --port=8000 \
