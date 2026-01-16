# Despliegue en Render

## Pasos:

### 1. Crear cuenta en Render
- Ve a: https://render.com
- Sign up (gratis)

### 2. Crear Base de Datos MySQL
1. Dashboard → "New +" → "MySQL"
2. Name: `hc-db`
3. Database: `hcservic`
4. User: `hcservic`
5. Region: Oregon (más cercano)
6. Plan: **Free** (90 días gratis, luego $7/mes)
7. "Create Database"
8. **Copia las credenciales** (Internal Database URL)

### 3. Crear Web Service
1. Dashboard → "New +" → "Web Service"
2. "Connect repository" → Selecciona: `Caskiuz/SistemadePrestamos`
3. Configuración:
   - Name: `hc-servicios`
   - Region: Oregon
   - Branch: `master`
   - Runtime: **Docker** o **Native Environment**
   - Build Command: `./build.sh`
   - Start Command: `php artisan migrate --force && php -S 0.0.0.0:$PORT -t public`
   - Plan: **Free**

### 4. Variables de Entorno
En "Environment" agrega:

```
APP_NAME=hcservicioindustrial
APP_ENV=production
APP_KEY=base64:G9L+XlUeHuOxXm5OWKS0wXHIRxgCGtcuuANWv8qAJfY=
APP_DEBUG=false
APP_URL=https://tu-app.onrender.com

DB_CONNECTION=mysql
DB_HOST=[COPIA DE INTERNAL HOST]
DB_PORT=3306
DB_DATABASE=hcservic
DB_USERNAME=hcservic
DB_PASSWORD=[COPIA DE PASSWORD]

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_CHANNEL=stack
LOG_LEVEL=error
```

### 5. Deploy
- Click "Create Web Service"
- Espera 5-10 minutos
- Tu app estará en: `https://hc-servicios.onrender.com`

## Notas:
- Plan Free: App se duerme después de 15 min sin uso
- Primera carga después de dormir: ~30 segundos
- MySQL Free: 90 días gratis, luego $7/mes
- Puedes ejecutar seeders: Settings → Shell → `php artisan db:seed`

## Credenciales Admin:
- Email: admin@admin.com
- Password: 12345678
