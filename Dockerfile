FROM php:8.4-cli

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo_pgsql pgsql zip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de Composer primero
COPY composer.json composer.lock ./

# Instalar dependencias de Laravel
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# Copiar el proyecto
COPY . .

# Permisos para Laravel
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Puerto utilizado por Render
EXPOSE 10000

# Servidor PHP
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}