FROM php:8.2-fpm-alpine

# Install system dependencies yang dibutuhkan Laravel
RUN apk update && apk add --no-cache \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy semua file proyek ke dalam container
COPY . .

# Install dependencies Laravel menggunakan Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Atur izin folder (permission) agar Laravel bisa menulis log dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Port yang akan digunakan oleh Railway
EXPOSE 8080

# Jalankan server bawaan artisan saat container dimulai
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]