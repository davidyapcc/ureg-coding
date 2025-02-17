FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    default-mysql-client

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create directory and set permissions
RUN mkdir -p /var/www/html \
    && mkdir -p /var/www/.npm \
    && mkdir -p /var/www/.composer \
    && chown -R www-data:www-data /var/www/html \
    && chown -R www-data:www-data /var/www/.npm \
    && chown -R www-data:www-data /var/www/.composer \
    && git config --global --add safe.directory /var/www/html

# Switch to www-data user
USER www-data

# Set environment variables
ENV npm_config_cache=/var/www/.npm
ENV COMPOSER_HOME=/var/www/.composer

# Copy composer files
COPY --chown=www-data:www-data composer.* ./

# Copy package files and install npm dependencies
COPY --chown=www-data:www-data package*.json ./
COPY --chown=www-data:www-data vite.config.js ./

# Install npm dependencies
RUN npm install && \
    npm install -D vite@latest @vitejs/plugin-vue@latest && \
    npm install --save-dev @vitejs/plugin-vue && \
    npm install --save-dev vite && \
    npm install --save-dev laravel-vite-plugin

# Copy the rest of the application code
COPY --chown=www-data:www-data . .

# Set proper permissions
RUN chmod -R 775 /var/www/html && \
    chmod +x /var/www/html/artisan

# Ensure .env exists by copying from .env.docker
RUN cp .env.docker .env && \
    chmod 644 .env

# Install composer dependencies
RUN composer install \
    --no-interaction \
    --prefer-dist

# Create build directory and set permissions
RUN mkdir -p public/build && \
    chmod -R 775 public/build

# Build frontend assets with debugging
RUN set -x && \
    ls -la resources/js && \
    ls -la resources/css && \
    NODE_ENV=production npm run build -- --debug && \
    ls -la public/build && \
    cat public/build/manifest.json || echo "Manifest not created!"

# Switch back to root for entrypoint setup
USER root

# Make entrypoint script executable
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Set entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]
