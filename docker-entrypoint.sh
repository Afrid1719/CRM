#!/bin/sh

set -e

# Detect available admin CLI
if command -v mysqladmin > /dev/null 2>&1; then
  DB_ADMIN="mysqladmin"
elif command -v mariadb-admin > /dev/null 2>&1; then
  DB_ADMIN="mariadb-admin"
else
  echo "❌ Neither mysqladmin nor mariadb-admin is available"
  exit 1
fi

echo "🔁 Waiting for MySQL to be ready using $DB_ADMIN..."
until $DB_ADMIN ping \
  -h"${DB_HOST:-crm-mysql}" \
  -u"${DB_USER:-user}" \
  -p"${DB_PASSWORD:-password}" \
  --silent \
  --ssl=OFF 2>/dev/null; do
  sleep 1
done

echo "✅ MySQL is ready!"

echo "🔑 Generating app key..."
php artisan key:generate

echo "🧱 Running migrations..."
php artisan migrate || true

echo "🔗 Linking storage..."
php artisan storage:link || true

echo "⚡ Starting Vite dev server..."
npm run dev &

echo "✅ Application is ready at https://crm.localhost"

exec php artisan serve \
  --host=0.0.0.0 \
  --port=8000 \
