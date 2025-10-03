FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    libpq-dev \
    libicu-dev \
    procps

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip intl

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files to leverage Docker cache
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist

# Copy the rest of the application files
COPY . .

# Install Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY .devcontainer/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Use development php.ini for better error reporting
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Configure PHP memory limit
RUN echo 'memory_limit = 256M' >> $PHP_INI_DIR/conf.d/docker-php-memory-limit.ini

# Set permissions for Laravel
# Create vscode user to match dev container user
RUN useradd -ms /bin/bash vscode

# Set permissions for Laravel
RUN chown -R vscode:vscode /app/storage /app/bootstrap/cache
