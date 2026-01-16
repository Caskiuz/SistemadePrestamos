# Roadmap Sistema de Préstamos y Almacenes (Tipo YoPresto)

## 1. Análisis y Diseño
- Definir entidades: clientes, préstamos, prendas/productos, almacenes, sucursales, ingresos, egresos, contratos.
- Mapear flujos de registro y préstamo considerando selección de almacén.
- Definir tipos de productos: electrodomésticos, vehículos, línea blanca, línea negra.

## 2. Estructura de Módulos
- **Clientes**
  - Registro, edición, búsqueda, historial.
- **Almacenes/Sucursales**
  - Registro de 3 almacenes con dirección.
  - Listado y edición de sucursales.
- **Productos/Prendas**
  - Registro de producto con selección de almacén (desplegable: Almacén 1, 2, 3).
  - Tipos: electrodomésticos, vehículos, línea blanca, línea negra.
  - Inventario por almacén.
- **Préstamos**
  - Registro de préstamo asociado a cliente y producto.
  - Generación de contrato de préstamo/arrendamiento en PDF.
  - Gestión de intereses, pagos, liquidaciones.
- **Contabilidad**
  - Registro de ingresos y egresos.
  - Reportes financieros.
- **Reportes**
  - Flujo de caja, inventario por almacén, préstamos, clientes, productos.
- **Configuración**
  - Empresa, sucursales, empleados, intereses, seguridad.

## 3. Formularios y UX/UI
- Formularios para alta/edición de clientes, productos (con almacén), préstamos, ingresos/egresos.
- Desplegable de almacenes en registro de productos.
- Listados filtrables por almacén, tipo de producto, estado.
- Generación y descarga de contrato PDF desde el detalle del préstamo.

## 4. Desarrollo Backend (Laravel)
- Modelos y migraciones para almacenes, productos, clientes, préstamos, ingresos, egresos, contratos.
- Controladores RESTful para cada módulo.
- Lógica para inventario por almacén y generación de PDF.
- Seguridad y roles.

## 5. Desarrollo Frontend
- Formularios con select de almacén.
- Vistas de inventario por almacén.
- Botón para generar/descargar contrato PDF en préstamos.
- Navegación y experiencia similar a YoPresto.

## 6. Pruebas y Validación
- Pruebas de flujos: registro de producto con almacén, préstamo, generación de PDF, ingresos/egresos.
- Validación de reportes y cálculos.

## 7. Despliegue y Documentación
- Documentar uso de almacenes, productos, préstamos y generación de contratos.
- Manual de usuario y guía rápida.

---

### Siguientes pasos sugeridos
1. Definir modelo de datos para almacenes, productos y préstamos.
2. Crear migraciones y seeders para 3 almacenes de ejemplo.
3. Implementar formulario de registro de producto con selección de almacén.
4. Agregar lógica para generación de contrato PDF en préstamos.

---

Este documento servirá como guía y checklist para el desarrollo completo del sistema, asegurando que no se pierda la lógica ni el orden de los cambios.