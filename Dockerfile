FROM php:8.4-cli

# Set system timezone to WIB (Asia/Jakarta)
RUN ln -fs /usr/share/zoneinfo/Asia/Jakarta /etc/localtime && dpkg-reconfigure -f noninteractive tzdata

# Install system dependencies including Node.js
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    libbrotli-dev \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip intl

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install Swoole extension
RUN pecl install swoole \
    && docker-php-ext-enable swoole

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install PHP dependencies first (so vendor/livewire/flux is available)
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build
RUN npm ci
RUN npm run build

# Ensure Octane is configured
RUN php artisan octane:install --server=swoole --no-interaction

# Run post-install scripts
RUN composer run-script post-autoload-dump

# Create necessary directories and set permissions
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views \
    && chmod -R 775 storage bootstrap/cache

# Create storage symlink for public file access
RUN php artisan storage:link --force

# Clean up Node.js to reduce image size
RUN apt-get remove -y nodejs && apt-get autoremove -y

# Expose port for Swoole
EXPOSE 8000

# Start Swoole server
CMD ["php", "artisan", "octane:start", "--host=0.0.0.0", "--port=8000"]