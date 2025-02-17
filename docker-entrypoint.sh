#!/bin/sh
set -e

# Function to wait for MySQL
wait_for_mysql() {
    echo "Waiting for MySQL to be ready..."
    maxTries=60
    while [ "$maxTries" -gt 0 ]; do
        if mysql -h db -u ureg -pureg_password -e "SELECT 1" >/dev/null 2>&1; then
            echo "MySQL is ready!"
            return 0
        fi
        maxTries=$(($maxTries - 1))
        echo "Waiting... $maxTries attempts left"
        sleep 1
    done
    echo >&2 "Error: Could not connect to MySQL after 60 seconds"
    return 1
}

# Function to run Laravel setup
setup_laravel() {
    echo "Setting up Laravel application..."

    # Clear all caches
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    php artisan route:clear

    # Generate app key if not already set
    if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:$(php artisan key:generate --show)" ]; then
        echo "Generating application key..."
        php artisan key:generate --force
    fi

    # Run migrations and seeders
    echo "Running database migrations..."
    if php artisan migrate --force; then
        echo "Running database seeders..."
        php artisan db:seed --force
    else
        echo >&2 "Error: Database migrations failed"
        return 1
    fi

    return 0
}

main() {
    # Wait for MySQL to be ready
    if ! wait_for_mysql; then
        return 1
    fi

    # Setup Laravel
    if ! setup_laravel; then
        return 1
    fi

    echo "Starting PHP-FPM..."
    exec php-fpm
}

main "$@"
