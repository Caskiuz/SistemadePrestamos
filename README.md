# HC Servicios Industrial - Sistema de Gestión

Sistema de gestión para préstamos, inventario y contabilidad.

## Credenciales Admin
- Email: admin@admin.com
- Password: 12345678

## Despliegue en Railway

### 1. Preparar Repositorio
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/tu-usuario/tu-repo.git
git push -u origin main
```

### 2. Crear Proyecto en Railway
1. Ve a [railway.app](https://railway.app)
2. "Start a New Project" → "Deploy from GitHub repo"
3. Selecciona tu repositorio

### 3. Agregar Base de Datos
1. En tu proyecto: "New" → "Database" → "Add MySQL"
2. Railway creará las variables automáticamente

### 4. Configurar Variables de Entorno
Copia las variables de `RAILWAY_ENV.txt` en Railway Dashboard → Variables

### 5. Generar Dominio
Settings → Networking → "Generate Domain"

### 6. Ejecutar Migraciones (opcional)
```bash
railway run php artisan migrate --seed
```

## Tecnologías
- Laravel 11
- PHP 8.2
- MySQL
- Bootstrap 4
