FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    default-mysql-client

# Instalar extensiones PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /app

# Copiar archivos
COPY . .

# Actualizar dependencias para PHP 8.2
RUN composer update --no-dev --optimize-autoloader --no-scripts

# Ejecutar scripts post-install manualmente
RUN composer dump-autoload --optimize

# Permisos
RUN chmod -R 777 storage bootstrap/cache

# Puerto
EXPOSE 8080

# Comando de inicio
CMD php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php -S 0.0.0.0:8080 -t public