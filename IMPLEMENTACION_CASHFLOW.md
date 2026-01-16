# Implementación Flujo de Caja - YoPresto Clone

## Archivos Creados

### 1. Vistas Blade (resources/views/)
- `layouts/app.blade.php` - Layout principal
- `partials/navbar.blade.php` - Barra de navegación
- `partials/sidebar.blade.php` - Menú lateral
- `partials/trial-alert.blade.php` - Alerta de prueba
- `reportes/cashflow/index.blade.php` - Vista principal
- `reportes/cashflow/header.blade.php` - Encabezado
- `reportes/cashflow/toolbar.blade.php` - Barra de herramientas con filtros
- `reportes/cashflow/table.blade.php` - Tabla de datos

### 2. Controlador
- `app/Http/Controllers/CashFlowController.php`

### 3. Modelo
- `app/Models/CashFlow.php`

### 4. Migración
- `database/migrations/2024_01_16_000001_create_cash_flow_table.php`

### 5. Assets Copiados
- `public/css/bundle.css`
- `public/css/vendor.css`
- `public/css/roboto-fontface.css`
- `public/js/bundle.js`
- `public/js/vendor.js`
- `public/js/cashflow.js`
- `public/images/logo-white.png`

### 6. Ruta
- `/reportes/cashflow` - GET

## Próximos Pasos

1. **Ejecutar migración:**
```bash
php artisan migrate
```

2. **Crear datos de prueba en el controlador o seeder**

3. **Ajustar el modelo User para incluir relaciones:**
```php
public function branch() {
    return $this->belongsTo(Branch::class);
}

public function company() {
    return $this->belongsTo(Company::class);
}
```

4. **Crear modelos Branch y Company si no existen**

5. **Ajustar rutas en navbar y sidebar según tus rutas existentes**

6. **Probar la vista accediendo a:**
```
http://127.0.0.1:8000/reportes/cashflow
```

## Estructura de la Base de Datos

### Tabla: cash_flow
- id
- fecha (datetime)
- usuario_id (FK users)
- concepto (string)
- detalles (string nullable)
- monto (decimal 10,2)
- tipo_movimiento (enum: entrada, salida)
- branch_id (FK branches)
- timestamps

## Funcionalidades Implementadas

✅ Filtro por fecha (desde/hasta)
✅ Filtro por tipo de concepto
✅ Cálculo automático de saldo
✅ Impresión de reporte
✅ Diseño idéntico a YoPresto
✅ Responsive
✅ Menú lateral con navegación
✅ Navbar con usuario y sucursal

## Conceptos de Movimientos

0. Préstamo
1. Pago de interés extemporáneo
2. Pago de intereses
3. Abono a capital
4. Abono a apartado
5. Venta
6. Compra
7. Cancelación de préstamo
8. Depósito
9. Retiro
10. Cancelación de compra
11. Apartado expirado
12. Cancelación de venta
13. Gasto
14. Reposición de boleta
