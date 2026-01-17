FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    default-mysql-client \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /app

# Copiar composer files primero
COPY composer.json ./

# Actualizar dependencias para PHP 8.2 sin scripts
RUN composer update --no-dev --optimize-autoloader --no-scripts

# Copiar resto de archivos
COPY . .

# Permisos
RUN chmod -R 777 storage bootstrap/cache

# Puerto
EXPOSE 8080

# Comando de inicio
CMD php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear && mkdir -p storage/framework/sessions && mkdir -p storage/framework/views && mkdir -p storage/framework/cache && mkdir -p storage/logs && chmod -R 775 storage && chmod -R 775 bootstrap/cache && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force && php artisan admin:create && php -S 0.0.0.0:8080 -t public