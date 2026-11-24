
# ==========================================
# 1. PHP BASE IMAGE
# ==========================================
FROM php:8.2-apache AS php-base

RUN apt-get update && apt-get install -y --no-install-recommends \
    ca-certificates \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        mbstring \
        bcmath \
        exif \
        pcntl \
        gd \
        zip \
        opcache \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html


# ==========================================
# 2. INSTALL PHP DEPENDENCIES
# ==========================================
FROM php-base AS vendor

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --no-scripts

COPY . .

RUN composer dump-autoload \
    --optimize \
    --no-dev \
    --no-interaction \
    --no-scripts


# ==========================================
# 3. BUILD FRONTEND ASSETS
# ==========================================
FROM node:20-bookworm-slim AS frontend

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build


# ==========================================
# 4. PRODUCTION IMAGE
# ==========================================
FROM php-base AS production

WORKDIR /var/www/html

COPY . .

COPY --from=vendor /var/www/html/vendor ./vendor

COPY --from=frontend /app/public/build ./public/build

# Configure Apache to serve Laravel public directory
# and listen on Render's default port.
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' \
        /etc/apache2/sites-available/000-default.conf \
    && sed -ri 's/^Listen 80$/Listen 10000/' \
        /etc/apache2/ports.conf \
    && sed -ri 's/<VirtualHost \*:80>/<VirtualHost *:10000>/' \
        /etc/apache2/sites-available/000-default.conf \
    && printf '\n<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>\n' \
        >> /etc/apache2/apache2.conf \
    && mkdir -p \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        storage/app/public \
        bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwx storage bootstrap/cache

ENV PORT=10000

EXPOSE 10000

# Discover packages, create storage link,
# apply database migrations, then start Apache.
CMD ["sh", "-c", "php artisan package:discover --ansi && php artisan storage:link && php artisan migrate --force && apache2-foreground"]
