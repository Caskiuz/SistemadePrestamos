# Documentación del Sistema de Préstamos tipo YoPresto

## 1. Descripción General
Sistema integral para la gestión de préstamos con prendas, compras, ventas, apartados, ingresos, egresos y reportes, inspirado en la experiencia YoPresto. Incluye módulos para clientes, sucursales, almacenes, empleados, productos/prendas, préstamos, contabilidad, reportes, configuración y seguridad.

## 2. Módulos y Flujos Principales

### Clientes
- Alta, edición, búsqueda, historial, cotitular, fotografías.
- Puntuación automática según comportamiento.

### Sucursales/Almacenes
- Registro, edición, selección activa, eliminación (solo admin).

### Empleados
- Alta, edición, roles, horarios, cambio de contraseña, eliminación.

### Productos/Prendas
- Registro con selección de almacén y tipo.
- Inventario por almacén, historial de movimientos.

### Préstamos
- Registro asociado a cliente y productos.
- Selección de intereses, cálculo automático, pagos, liquidaciones, refrendos, abonos a capital.
- Generación de boleta y recibos PDF.

### Compras y Ventas
- Compra directa de prendas.
- Venta y apartados con control de plazos y anticipos.

### Contabilidad
- Registro de ingresos y egresos.
- Flujo de caja y reportes financieros.

### Reportes
- Clientes, préstamos, prendas, compras, ventas, apartados, respaldo en Excel.

### Configuración y Seguridad
- Datos de empresa, sucursales, empleados, intereses, recibos, región, roles y permisos.

## 3. Flujos de Uso

### Alta de Cliente
1. Acceder a módulo Clientes.
2. Completar formulario de alta.
3. Adjuntar fotografía y cotitular si aplica.
4. Guardar y verificar en listado.

### Registro de Préstamo
1. Seleccionar cliente y productos/prendas.
2. Definir intereses y condiciones.
3. Confirmar y generar boleta PDF.

### Compra/Venta/Apartado
1. Seleccionar prenda y operación (compra, venta, apartado).
2. Completar datos requeridos (plazo, anticipo, etc).
3. Confirmar y registrar movimiento.

### Ingresos/Egresos
1. Acceder a contabilidad.
2. Registrar ingreso o egreso con concepto y monto.

### Generación de Contratos/Boletas
1. Desde el detalle de préstamo, usar botón "Generar PDF".
2. Descargar o imprimir documento.

## 4. Endpoints Principales (API)

- Clientes: `/api/clientes` (CRUD)
- Préstamos: `/api/prestamos` (CRUD, pagos, liquidaciones, PDF)
- Prendas: `/api/prendas` (CRUD, historial)
- Compras: `/api/compras` (CRUD)
- Ventas: `/api/ventas` (CRUD)
- Apartados: `/api/apartados` (CRUD)
- Ingresos/Egresos: `/api/ingresos`, `/api/egresos` (CRUD)
- Reportes: `/api/reportes/*`
- Configuración: `/api/configuracion` (empresa, sucursal, empleados, intereses, recibos, región)
- Seguridad: `/api/usuarios`, `/api/roles`, `/api/permisos`

## 5. Manual de Usuario y Guía Rápida

### Acceso y Navegación
- Iniciar sesión con usuario y contraseña.
- Usar menú lateral para navegar entre módulos.
- Formularios modales y validaciones amigables.

### Operaciones Frecuentes
- Alta/edición de clientes, productos, préstamos, compras, ventas, apartados, ingresos/egresos.
- Generar y descargar boletas/contratos PDF.
- Consultar reportes y exportar a Excel.

### Seguridad
- Roles: Empleado, Supervisor, Gerente, Administrador.
- Permisos según rol y sucursal activa.

## 6. Despliegue

1. Clonar repositorio y configurar `.env`.
2. Ejecutar `composer install` y `npm install`.
3. Migrar y poblar base de datos: `php artisan migrate:fresh --seed`.
4. Levantar servidor: `php artisan serve`.
5. Acceder vía navegador a la URL indicada.

---

Para detalles avanzados, revisar los controladores y rutas en el backend. Cualquier duda, consultar al equipo de desarrollo.
