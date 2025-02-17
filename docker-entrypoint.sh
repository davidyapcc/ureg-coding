#!/bin/sh
set -e

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
maxTries=60
while [ "$maxTries" -gt 0 ]; do
    if mysql -h db -u ureg -pureg_password -e "SELECT 1" >/dev/null 2>&1; then
        break
    fi
    maxTries=$(($maxTries - 1))
    sleep 1
done

if [ "$maxTries" -le 0 ]; then
    echo >&2 "Error: Could not connect to MySQL after 60 seconds"
    exit 1
fi

echo "MySQL is ready!"

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Generate app key if not set
php artisan key:generate --force

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --force

# Start PHP-FPM
exec php-fpm
