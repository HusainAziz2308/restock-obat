# Tambahkan ini di atas baris RUN composer untuk mengizinkan plugin
ENV COMPOSER_ALLOW_SUPERUSER=1

# Ubah baris RUN composer install menjadi seperti ini (ditambah --no-dev)
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs