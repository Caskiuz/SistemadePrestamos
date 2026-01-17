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
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /app

# Copiar composer files primero
COPY composer.json composer.lock ./

# Instalar dependencias sin scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copiar resto de archivos
COPY . .

# Permisos
RUN chmod -R 777 storage bootstrap/cache

# Puerto
EXPOSE 8080

# Comando de inicio (aquí sí ejecutamos los comandos Laravel)
CMD php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force && php -S 0.0.0.0:8080 -t public