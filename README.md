# Préstamos Santa Ana - Sistema de Gestión

Sistema de gestión para préstamos, inventario y contabilidad.

## Credenciales Admin
- Email: admin@admin.com
- Password: 12345678

## Instalación Local

### 1. Clonar Repositorio
```bash
git clone https://github.com/tu-usuario/tu-repo.git
cd app-hc
```

### 2. Instalar Dependencias
```bash
composer install
npm install
```

### 3. Configurar Base de Datos
1. Crear base de datos MySQL local
2. Copiar `.env.example` a `.env`
3. Configurar variables de base de datos en `.env`

### 4. Ejecutar Migraciones
```bash
php artisan migrate --seed
php artisan storage:link
```

### 5. Iniciar Servidor Local
```bash
php artisan serve
```

### 6. Acceso Remoto con Cloudflare Tunnel
Para compartir acceso remoto, usar Cloudflare Tunnel:
```bash
cloudflared tunnel --url http://localhost:8000
```

## Tecnologías
- Laravel 11
- PHP 8.2
- MySQL
- Bootstrap 4
