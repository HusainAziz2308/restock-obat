FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libicu-dev \
    libzip-dev \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-install intl zip pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files and install PHP dependencies
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy package files and build frontend assets
COPY package.json package-lock.json* ./
RUN npm install && npm run build

# Copy the rest of the application
COPY . .

# Generate optimized autoload and cache config
RUN composer dump-autoload --optimize

EXPOSE ${PORT:-8000}

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}