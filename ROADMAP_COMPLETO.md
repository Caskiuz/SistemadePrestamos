# Roadmap Completo: Sistema de Préstamos tipo YoPresto

## 1. Análisis y Diseño
- Estudio de todos los módulos YoPresto: Clientes, Préstamos, Prendas, Historial, Reportes, Configuración de empresa y sucursal, empleados, intereses, recibos, región, boleta de empeño, suscripción.
- Definir flujos de usuario y casos de uso: alta de cliente, registro de préstamo, gestión de prendas, compras, ventas, apartados, reportes, configuración, roles y seguridad.
- Diseño de base de datos: relaciones entre clientes, préstamos, prendas, pagos, sucursales, almacenes, empleados, intereses, contratos, ingresos/egresos, apartados, compras, ventas.
- Definir tipos de préstamos: línea blanca (electrodomésticos), línea negra (joyas, electrónicos, vehículos, etc).

## 2. Estructura de Módulos
- **Clientes**
  - Registro, edición, búsqueda, historial, cotitular, fotografías.
  - Puntuación de cliente según comportamiento (refrendos, liquidaciones, expirados).
- **Sucursales/Almacenes**
  - Registro de sucursales/almacenes con dirección.
  - Selección de sucursal activa, edición, eliminación (solo admin).
- **Empleados**
  - Registro, edición, roles (Empleado, Supervisor, Gerente, Administrador), horarios, cambio de contraseña, eliminación.
- **Productos/Prendas**
  - Registro de producto/prenda con selección de almacén.
  - Tipos: electrodomésticos, vehículos, línea blanca, línea negra, joyas, celulares, etc.
  - Inventario por almacén, historial de prendas (en venta, apartados, empeñados, vendidas, liquidadas, canceladas).
- **Préstamos**
  - Registro de préstamo asociado a cliente y producto(s).
  - Selección de categoría de intereses, cálculo automático de valuación (oro/plata), gestión de intereses, pagos, liquidaciones, refrendos, abonos a capital.
  - Boleta de empeño y recibos (configurables, impresión PDF, plantillas personalizadas).
  - Acciones: cancelar, marcar como expirado, imprimir boleta, recibo.
  - Prendas relacionadas a préstamo.
- **Compras y Ventas**
  - Compra directa de prendas a clientes.
  - Venta de prendas (en venta, apartados, vendidas).
  - Apartados: plazo, porcentaje de anticipo, vencimiento.
- **Contabilidad**
  - Registro de ingresos y egresos.
  - Flujo de caja, reportes financieros.
- **Reportes**
  - Clientes (por orden, puntuación, cumpleaños, sin actividad).
  - Préstamos (vigentes, por vencer, vencidos, expirados, liquidados, cancelados).
  - Prendas (en venta, apartados, empeñados, vendidas, liquidadas, canceladas).
  - Compras, ventas, apartados, respaldo en Excel.
- **Configuración**
  - Empresa: datos generales, sucursales, empleados, intereses, recibos, región, suscripción.
  - Sucursal: datos generales, intereses, operación, recibos, región, empleados, avanzado (eliminar datos de prueba).
  - Seguridad y roles de usuario.

## 3. Formularios y UX/UI
- Replicar experiencia de usuario YoPresto: menús laterales, formularios modales, búsqueda rápida, filtros, dashboard inicial.
- Formularios para alta/edición de clientes, productos, préstamos, compras, ventas, apartados, ingresos/egresos, empleados, configuración.
- Validaciones y mensajes de error amigables.
- Desplegables para selección de almacén, sucursal, tipo de producto, categoría de intereses, etc.
- Generación y descarga de boleta/contrato PDF desde el detalle del préstamo.

## 4. Desarrollo Backend (Laravel)
- Modelos y migraciones para todas las entidades.
- Seeders para datos de ejemplo (sucursales, almacenes, categorías, intereses, empleados, etc).
- Controladores RESTful para cada módulo.
- Lógica de negocio para préstamos, intereses, pagos, liquidaciones, inventario, compras, ventas, apartados, contratos, reportes.
- Seguridad: autenticación, roles y permisos, horarios de acceso.
- API para generación de PDF (boleta, recibos, contratos).

## 5. Desarrollo Frontend
- Formularios con select de almacén, sucursal, tipo de producto, intereses, etc.
- Vistas de inventario por almacén, historial de clientes, préstamos, prendas, compras, ventas, apartados.
- Botón para generar/descargar boleta/contrato PDF en préstamos.
- Navegación y experiencia similar a YoPresto.

## 6. Pruebas y Validación
- Pruebas unitarias y de integración para lógica de negocio.
- Pruebas de usuario para flujos principales.
- Validación de reportes, cálculos financieros, generación de PDF.

## 7. Despliegue y Documentación
- Documentar uso de almacenes, productos, préstamos, compras, ventas, apartados, generación de contratos.
- Manual de usuario y guía rápida.
- Despliegue en servidor de pruebas y luego en producción.

---

## Siguientes pasos sugeridos
1. Definir modelo de datos para sucursales, almacenes, productos, clientes, préstamos, intereses, empleados, compras, ventas, apartados, ingresos/egresos.
2. Crear migraciones y seeders para datos de ejemplo.
3. Implementar formularios principales y flujos base.
4. Agregar lógica para generación de boleta/contrato PDF en préstamos.
5. Iterar agregando funcionalidades y módulos según el roadmap.

---

Este documento es el roadmap completo y checklist para el desarrollo del sistema, asegurando que no se pierda la lógica ni el orden de los cambios. Incluye todos los módulos y flujos documentados en YoPresto.