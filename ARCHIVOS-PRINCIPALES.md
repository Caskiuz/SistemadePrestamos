# ARCHIVOS PRINCIPALES DEL PROYECTO - PRÉSTAMOS SANTA ANA

## 🎯 ARCHIVOS CLAVE QUE DEBES EDITAR

### 📱 LAYOUTS (Solo estos 2)
- `resources/views/layouts/main.blade.php` - Layout principal del sistema
- `resources/views/layouts/login-simple.blade.php` - Layout del login

### 🔐 AUTENTICACIÓN
- `app/Http/Controllers/AuthController.php` - Controlador de login/logout
- `app/Http/Middleware/Authenticate.php` - Middleware de autenticación
- `app/Http/Middleware/RolContable.php` - Middleware de roles

### 🏠 DASHBOARD
- `app/Http/Controllers/Dashboard.php` - Controlador principal del dashboard
- `resources/views/modules/dashboard/home.blade.php` - Vista del dashboard

### 👥 CLIENTES
- `app/Http/Controllers/ClienteController.php` - Controlador de clientes
- `resources/views/modules/clientes/create.blade.php` - Formulario nuevo cliente
- `resources/views/modules/clientes/index.blade.php` - Lista de clientes

### 💰 PRÉSTAMOS
- `app/Http/Controllers/PrestamoController.php` - Controlador de préstamos
- `resources/views/modules/prestamos/` - Vistas de préstamos

### 🎨 ESTILOS CSS (Mobile-First)
- `public/css/responsive-global.css` - CSS responsive global
- `public/css/mobile-components.css` - Componentes móviles
- `public/css/yopresto-sidebar.css` - Sidebar responsive
- `public/css/bolivia-currency.css` - Formato de moneda boliviana

### ⚙️ CONFIGURACIÓN
- `.env` - Configuración de producción (BASE DE DATOS)
- `bootstrap/app.php` - Configuración de middlewares
- `routes/web.php` - Todas las rutas del sistema

### 🗄️ MODELOS PRINCIPALES
- `app/Models/User.php` - Usuarios
- `app/Models/Cliente.php` - Clientes
- `app/Models/Prestamo.php` - Préstamos
- `app/Models/Producto.php` - Productos/Prendas
- `app/Models/CashFlow.php` - Flujo de caja

## 🗑️ ARCHIVOS ELIMINADOS (Ya no existen)
- Middlewares duplicados (BoliviaConfig, CustomAuth, etc.)
- Layouts obsoletos (app.blade.php, login.blade.php)
- Helpers duplicados (BoliviaHelper, BoliviaConfig)
- Archivos .env duplicados
- Archivos SQL de backup
- Archivos ZIP obsoletos

## 📝 REGLAS DE EDICIÓN
1. **Login**: Solo edita `login-simple.blade.php`
2. **Sistema**: Solo edita `main.blade.php`
3. **Autenticación**: Solo `AuthController.php` y `Authenticate.php`
4. **Estilos**: Usa los CSS mobile-first existentes
5. **Base de datos**: Solo edita `.env` para credenciales

## 🚀 COMANDOS DE LIMPIEZA
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

¡PROYECTO LIMPIO Y ORGANIZADO! 🎉