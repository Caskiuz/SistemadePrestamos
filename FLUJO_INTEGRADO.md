# Flujo de Datos Integrado - Sistema YoPresto

## ✅ IMPLEMENTADO

### 1. Flujo de Préstamos (Empeño)
**Cuando se crea un préstamo:**
- ✅ Se registra en `prestamos`
- ✅ Se crean/asocian productos con estado `empeñado`
- ✅ Se registra en `prestamo_operaciones`
- ✅ Se registra en `cash_flow` como SALIDA (dinero que sale de caja)
- ✅ Se registra en historial automáticamente

**Cuando se paga un préstamo:**
- ✅ Se registra en `pagos`
- ✅ Se actualiza `prestamo_operaciones`
- ✅ Se registra en `cash_flow` como ENTRADA
  - Refrendo → "Pago de intereses"
  - Abono a capital → "Abono a capital"
  - Liquidación → "Cancelación de préstamo"

**Cuando se liquida completamente:**
- ✅ Estado del préstamo → `liquidado`
- ✅ Productos → `disponible`

**Cuando expira un préstamo:**
- ✅ Estado del préstamo → `expirado`
- ✅ Productos → `en_venta`

### 2. Flujo de Ventas
**Cuando se vende una prenda:**
- ✅ Se registra en `ventas`
- ✅ Producto cambia a estado `vendido`
- ✅ Se registra en `cash_flow` como ENTRADA
- ✅ Solo se pueden vender productos con estado `disponible` o `en_venta`

### 3. Flujo de Compras
**Cuando se compra una prenda:**
- ✅ Se crea el producto con estado `disponible`
- ✅ Se registra en `compras`
- ✅ Se registra en `cash_flow` como SALIDA
- ✅ La prenda queda disponible para empeñar o vender

### 4. Estados de Productos
```
DISPONIBLE → (empeñar) → EMPEÑADO
                            ↓
                    (liquidar/cancelar)
                            ↓
                        DISPONIBLE
                            ↓
                        (vender)
                            ↓
                        VENDIDO

EMPEÑADO → (expirar) → EN_VENTA → (vender) → VENDIDO
```

### 5. Flujo de Caja Integrado
Todos los movimientos financieros se registran automáticamente:

**ENTRADAS (dinero que entra):**
- Pago de intereses (refrendo)
- Abono a capital
- Liquidación de préstamo
- Venta de prenda

**SALIDAS (dinero que sale):**
- Préstamo otorgado
- Compra de prenda

### 6. Historial
Todas las operaciones quedan registradas en:
- `prestamo_operaciones` (para préstamos)
- `cash_flow` (para flujo de caja)
- Timestamps en cada tabla

## Datos de Prueba Eliminados
✅ Se eliminó el anillo de prueba que aparecía en prendas

## Próximos Pasos Sugeridos

1. **Apartados**: Integrar con flujo de caja
2. **Depósitos/Retiros**: Agregar botones funcionales en reportes
3. **Gastos**: Integrar con flujo de caja
4. **Dashboard**: Mostrar métricas en tiempo real
5. **Reportes**: Generar reportes basados en cash_flow

## Verificación del Flujo

Para verificar que todo funciona:

1. Crear un cliente
2. Crear un préstamo (empeño)
   - ✅ Verifica que aparezca en flujo de caja como SALIDA
   - ✅ Verifica que la prenda esté EMPEÑADA
3. Pagar intereses (refrendo)
   - ✅ Verifica que aparezca en flujo de caja como ENTRADA
4. Liquidar préstamo
   - ✅ Verifica que aparezca en flujo de caja como ENTRADA
   - ✅ Verifica que la prenda esté DISPONIBLE
5. Vender la prenda
   - ✅ Verifica que aparezca en flujo de caja como ENTRADA
   - ✅ Verifica que la prenda esté VENDIDA

## Notas Importantes

- Todos los montos en flujo de caja son REALES
- No hay datos ficticios
- El saldo se calcula automáticamente
- Cada operación tiene trazabilidad completa
