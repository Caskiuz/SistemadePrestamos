# 🐳 DOCKER + POSTGRESQL EN RENDER

## ✅ Dockerfile Corregido
El CMD ahora incluye TODOS los comandos que necesitas:

```dockerfile
CMD php artisan config:clear && 
    php artisan route:clear && 
    php artisan view:clear && 
    php artisan cache:clear && 
    mkdir -p storage/framework/sessions && 
    mkdir -p storage/framework/views && 
    mkdir -p storage/framework/cache && 
    mkdir -p storage/logs && 
    chmod -R 775 storage && 
    chmod -R 775 bootstrap/cache && 
    php artisan config:cache && 
    php artisan route:cache && 
    php artisan view:cache && 
    php artisan migrate --force && 
    php artisan admin:create && 
    php -S 0.0.0.0:8080 -t public
```

## 🚀 Para Desplegar:

1. **Variables de entorno:** Copia `RENDER_DOCKER_ENV.txt` a Render
2. **Servicio:** Web Service + Docker 
3. **Base de datos:** PostgreSQL (automático en Render)
4. **Build/Start Commands:** VACÍOS (usa Dockerfile)

## 📋 Credenciales:
- **Email:** admin@admin.com
- **Password:** 12345678

## ⚠️ Importante:
- PostgreSQL configurado para Render
- Todos los comandos están en el Dockerfile
- NO necesitas Build/Start Commands en Render