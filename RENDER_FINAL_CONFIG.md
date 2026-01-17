# RENDER - CONFIGURACIÓN DEFINITIVA

## Variables de entorno en Render:

```
APP_NAME=hcservicioindustrial
APP_ENV=production
APP_KEY=base64:G9L+XlUeHuOxXm5OWKS0wXHIRxgCGtcuuANWv8qAJfY=
APP_DEBUG=false
APP_URL=https://sistemadeprestamos.onrender.com

DB_CONNECTION=pgsql
DATABASE_URL=${{DATABASE_URL}}

SESSION_DRIVER=database
SESSION_LIFETIME=1440
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=false
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

CACHE_STORE=file
LOG_LEVEL=error
QUEUE_CONNECTION=sync

TRUST_PROXIES=*
```

## Build Command:
```
composer install --no-dev --optimize-autoloader && php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear
```

## Start Command:
```
php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force && php artisan admin:create && php artisan serve --host=0.0.0.0 --port=$PORT
```

**Con estas configuraciones basadas en lo que funcionó en Replit, debería funcionar en Render.**