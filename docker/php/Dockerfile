# Using the cli instead of fpm as we are not using fast cgi manager for web server
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    openssl \
    npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory
COPY . .

# Install Node dependencies
RUN npm install --legacy-peer-deps

# Build React frontend
RUN npm run build

# Generate self-signed SSL cert
RUN mkdir -p /etc/ssl/local && \
    openssl req -x509 -nodes -days 365 \
    -newkey rsa:2048 \
    -keyout /etc/ssl/local/crm.localhost.key \
    -out /etc/ssl/local/crm.localhost.crt \
    -subj "/CN=crm.localhost"

# Set permissions (optional)
RUN chown -R www-data:www-data /var/www/html

# Entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
