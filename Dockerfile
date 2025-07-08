# Using the cli instead of fpm as we are not using fast cgi manager for web server
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

# Copy application files (excluding node_modules/vendor via .dockerignore)
COPY . .

# Fix file permissions
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
