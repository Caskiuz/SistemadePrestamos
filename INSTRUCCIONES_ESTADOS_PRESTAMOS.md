# Instrucciones para Actualizar Estados de Préstamos

## Cambios Realizados

Se ha actualizado el sistema para que coincida exactamente con YoPresto:

### Estados Anteriores:
- activo (mostrado como "Vigentes")
- por_vencer (mostrado como "Por vencer") 
- vencido (mostrado como "Vencidos")
- liquidado (mostrado como "Liquidados")

### Estados Nuevos (igual que YoPresto):
- **activo** (mostrado como "Activos")
- **vencido** (mostrado como "Vencidos")  
- **expirado** (mostrado como "Expirados")
- **liquidado** (mostrado como "Liquidados")
- **cancelado** (mostrado como "Cancelados")

## Archivos Modificados:

1. **database/migrations/2024_01_20_000000_update_prestamos_estados.php** - Nueva migración
2. **resources/views/modules/prestamos/index.blade.php** - Pestañas actualizadas
3. **resources/views/modules/prestamos/show.blade.php** - Vista de detalle actualizada
4. **app/Http/Controllers/PrestamoController.php** - Lógica actualizada
5. **app/Console/Commands/ActualizarPrestamosVencidos.php** - Comando actualizado
6. **database/seeders/ActualizarEstadosPrestamosSeeder.php** - Nuevo seeder

## Comandos a Ejecutar:

```bash
# 1. Ejecutar la migración
php artisan migrate

# 2. Ejecutar el seeder para actualizar préstamos existentes
php artisan db:seed --class=ActualizarEstadosPrestamosSeeder

# 3. Actualizar el comando programado (opcional)
php artisan prestamos:actualizar-estados
```

## Lógica de Estados:

1. **Activo**: Préstamo vigente, dentro del plazo
2. **Vencido**: Préstamo que pasó la fecha de vencimiento (automático)
3. **Expirado**: Préstamo vencido por más de 30 días (automático)
4. **Liquidado**: Préstamo pagado completamente
5. **Cancelado**: Préstamo cancelado manualmente

## Funcionalidades:

- **Actualización automática**: Los estados se actualizan automáticamente al cargar la vista
- **Transiciones**: activo → vencido → expirado (automático)
- **Acciones por estado**:
  - Activo/Vencido: Refrendar, Abonar, Liquidar, Cancelar
  - Vencido: También puede marcarse como Expirado
  - Expirado: Puede crear Subasta
  - Liquidado/Cancelado: Solo visualización

## Colores de Badges:

- Activo: Verde (badge-success)
- Vencido: Amarillo (badge-warning)  
- Expirado: Rojo (badge-danger)
- Liquidado: Gris (badge-secondary)
- Cancelado: Negro (badge-dark)

¡El sistema ahora funciona exactamente igual que YoPresto!