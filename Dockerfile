FROM php:8.4-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    libzip-dev libicu-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip

COPY . .

RUN mkdir -p bootstrap/cache storage/framework/cache storage/framework/sessions storage/framework/views storage/logs \
    && chmod -R 775 bootstrap/cache storage

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --optimize-autoloader --no-scripts

RUN echo "=== Checking autoload_files.php ===" \
    && cat vendor/composer/autoload_files.php \
    && echo "=== Checking for index.php references in vendor ===" \
    && grep -rl "public/index.php" vendor/ --include="*.php" || echo "no match in vendor" \
    && echo "=== artisan list output ===" \
    && php artisan list 2>&1 | head -50

EXPOSE 8000
CMD ["sh", "-c", "php artisan package:discover --ansi && php artisan migrate --force && php -S 0.0.0.0:8000 -t public"]