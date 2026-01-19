# Préstamos Santa Ana - Sistema de Gestión

Sistema de gestión para préstamos, inventario y contabilidad desarrollado con Laravel 11. **Configurado para Bolivia con moneda en Bolivianos (Bs)**.

## 🚀 Características

- **Gestión de Préstamos**: Registro, seguimiento y liquidación de préstamos
- **Inventario**: Control de productos empeñados y en venta
- **Clientes**: Administración de base de datos de clientes
- **Contabilidad**: Registro de ingresos, egresos y flujo de caja
- **Reportes**: Análisis financiero y operativo
- **Diseño Mobile-First**: Optimizado para dispositivos móviles
- **Moneda Boliviana**: Sistema configurado para usar Bolivianos (Bs) como moneda principal

## 📋 Requisitos

- PHP 8.2 o superior
- MySQL 5.7 o superior
- Composer
- Node.js y NPM (opcional, para assets)

## 🛠️ Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/tu-usuario/prestamos-santa-ana.git
cd prestamos-santa-ana
```

### 2. Instalar dependencias
```bash
composer install
```

### 3. Configurar entorno
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar base de datos
Editar `.env` con tus credenciales de MySQL:
```env
DB_DATABASE=app_hc
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### 5. Ejecutar migraciones
```bash
php artisan migrate --seed
```

### 6. Crear enlace de storage
```bash
php artisan storage:link
```

### 7. Iniciar servidor
```bash
php artisan serve
```

## 👤 Credenciales por defecto

- **Email**: admin@admin.com
- **Password**: 12345678

## 🇧🇴 Configuración Regional

- **País**: Bolivia
- **Moneda**: Boliviano (Bs)
- **Zona Horaria**: America/La_Paz
- **Idioma**: Español (Bolivia)
- **Formato de Fecha**: dd/mm/yyyy
- **Separador Decimal**: Coma (,)
- **Separador de Miles**: Punto (.)

## 💰 Sistema de Moneda

El sistema está completamente configurado para usar **Bolivianos (Bs)** como moneda principal:

- Todos los montos se muestran con el símbolo "Bs"
- Formateo automático: `Bs 1.234,56`
- CSS global que reemplaza cualquier símbolo "$" por "Bs"
- JavaScript que actualiza contenido dinámico
- Helpers de formateo configurados para Bolivia

## 📱 Acceso remoto

Para compartir acceso remoto usando Cloudflare Tunnel:
```bash
cloudflared tunnel --url http://localhost:8000
```

## 🏗️ Tecnologías

- **Backend**: Laravel 11, PHP 8.2
- **Base de datos**: MySQL
- **Frontend**: Bootstrap 4, JavaScript vanilla
- **PDF**: DomPDF
- **Autenticación**: Laravel Auth

## 📁 Estructura del proyecto

```
app-hc/
├── app/
│   ├── Http/Controllers/     # Controladores
│   ├── Models/              # Modelos Eloquent
│   └── Helpers/             # Clases auxiliares
├── database/
│   ├── migrations/          # Migraciones de BD
│   └── seeders/            # Datos iniciales
├── public/
│   ├── fotos/              # Imágenes de productos
│   └── images/             # Assets estáticos
├── resources/
│   └── views/              # Vistas Blade
└── routes/
    └── web.php             # Rutas web
```

## 🔧 Funcionalidades principales

### Préstamos
- Registro de nuevos préstamos
- Cálculo automático de intereses
- Gestión de pagos y refrendos
- Generación de contratos PDF
- Estados: activo, vencido, liquidado, expirado

### Inventario
- Catálogo de productos (joyas, artículos, garrafas, vehículos)
- Gestión de fotos con sistema unificado
- Estados: disponible, empeñado, en venta, apartado, vendido
- Filtros por estado y búsqueda

### Clientes
- Base de datos completa de clientes
- Historial de préstamos por cliente
- Información de contacto y documentos

### Contabilidad
- Registro de ingresos y egresos
- Flujo de caja automático
- Reportes financieros
- Gestión de sueldos

## 🔒 Seguridad

- Autenticación requerida para todas las funciones
- Validación de datos en servidor
- Protección CSRF
- Sanitización de uploads

## 📊 Reportes disponibles

- Préstamos vigentes, vencidos y expirados
- Inventario por estado
- Flujo de caja por período
- Rentabilidad y estadísticas

## 🤝 Contribuir

1. Fork el proyecto
2. Crear rama feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Crear Pull Request

## 📄 Licencia

Este proyecto es privado y propietario.

## 📞 Soporte

Para soporte técnico, contactar al desarrollador.

---

**Desarrollado para Préstamos Santa Ana** 🏪