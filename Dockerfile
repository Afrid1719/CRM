# Stage: Build
FROM php:8.2-cli-alpine

# Install system dependencies
RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    libpng-dev \
    libxml2-dev \
    oniguruma-dev \
    nodejs \
    npm \
    openssl \
    mysql-client \
    shadow \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# ------------------------
# 1. Copy composer files first for caching
# ------------------------
COPY composer.json composer.lock ./

# 2. Install PHP dependencies without running post-scripts (no artisan yet)
RUN composer install --no-interaction --prefer-dist --no-scripts

# ------------------------
# 3. Copy rest of the application (artisan included)
# ------------------------
COPY . .

# 4. Run post-autoload-dump scripts manually (artisan is now available)
RUN composer run-script post-autoload-dump

# ------------------------
# Optional npm caching step (improves rebuild time)
# ------------------------
COPY package.json package-lock.json ./
RUN npm install --legacy-peer-deps

# Fix file permissions (optional)
RUN chown -R www-data:www-data /var/www/html

# Generate self-signed SSL cert
RUN mkdir -p /etc/ssl/local && \
    openssl req -x509 -nodes -days 365 \
    -newkey rsa:2048 \
    -keyout /etc/ssl/local/crm.localhost.key \
    -out /etc/ssl/local/crm.localhost.crt \
    -subj "/CN=crm.localhost"

# Entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
