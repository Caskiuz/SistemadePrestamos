<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Renovacion;
use App\Models\PrestamoOperacion;
use App\Models\CashFlow;

class RenovacionController extends Controller
{
    public function renovar(Request $request, $id)
    {
        $prestamo = Prestamo::findOrFail($id);
        
        $validated = $request->validate([
            'intereses_pagados' => 'required|numeric|min:0',
            'dias_extension' => 'required|integer|min:1|max:365',
            'observaciones' => 'nullable|string'
        ]);

        // Crear nuevo préstamo
        $nuevoPrestamo = Prestamo::create([
            'folio' => null, // Se genera automáticamente
            'cliente_id' => $prestamo->cliente_id,
            'almacen_id' => $prestamo->almacen_id,
            'interes_id' => $prestamo->interes_id,
            'monto' => $prestamo->monto,
            'interes_mensual' => $prestamo->interes_mensual,
            'monto_total' => $prestamo->monto + (($prestamo->monto * $prestamo->interes_mensual / 100) * ($validated['dias_extension'] / 30)),
            'monto_pagado' => 0,
            'monto_pendiente' => $prestamo->monto + (($prestamo->monto * $prestamo->interes_mensual / 100) * ($validated['dias_extension'] / 30)),
            'fecha_prestamo' => now(),
            'fecha_vencimiento' => now()->addDays($validated['dias_extension']),
            'plazo_dias' => $validated['dias_extension'],
            'estado' => 'activo'
        ]);

        // Transferir productos
        foreach ($prestamo->productos as $producto) {
            $nuevoPrestamo->productos()->attach($producto->id, ['valuacion' => $producto->pivot->valuacion]);
        }

        // Registrar renovación
        Renovacion::create([
            'prestamo_original_id' => $prestamo->id,
            'prestamo_nuevo_id' => $nuevoPrestamo->id,
            'monto_renovado' => $prestamo->monto,
            'intereses_pagados' => $validated['intereses_pagados'],
            'fecha_renovacion' => now(),
            'dias_extension' => $validated['dias_extension'],
            'observaciones' => $validated['observaciones'],
            'usuario_id' => auth()->id()
        ]);

        // Cerrar préstamo original
        $prestamo->update(['estado' => 'renovado']);

        // Registrar operaciones
        PrestamoOperacion::create([
            'prestamo_id' => $prestamo->id,
            'tipo' => 'renovacion',
            'cargo' => 0,
            'abono' => $validated['intereses_pagados'],
            'saldo' => 0,
            'usuario_id' => auth()->id(),
            'descripcion' => 'Renovado a préstamo #' . $nuevoPrestamo->id
        ]);

        // Registrar en cash flow
        if ($validated['intereses_pagados'] > 0) {
            CashFlow::create([
                'fecha' => now(),
                'usuario_id' => auth()->id(),
                'concepto' => 'Pago de intereses - Renovación',
                'detalles' => "Renovación préstamo {$prestamo->folio} a {$nuevoPrestamo->folio}",
                'monto' => $validated['intereses_pagados'],
                'tipo_movimiento' => 'entrada',
                'branch_id' => $prestamo->almacen_id
            ]);
        }

        return redirect()->route('prestamos.show', $nuevoPrestamo->id)
            ->with('success', 'Préstamo renovado exitosamente');
    }
}