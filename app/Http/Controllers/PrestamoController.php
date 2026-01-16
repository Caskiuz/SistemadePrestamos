<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Almacen;
use App\Models\Interes;
use App\Models\Pago;
use App\Models\PrestamoOperacion;

class PrestamoController extends Controller
{
    public function index(Request $request) {
        $query = Prestamo::with(['cliente', 'almacen', 'productos']);
        
        if ($request->status) {
            $query->where('estado', $request->status);
        } else {
            $query->where('estado', 'activo');
        }
        
        if ($request->q) {
            $query->where(function($q) use ($request) {
                $q->whereHas('cliente', function($subQ) use ($request) {
                    $subQ->where('nombre', 'like', '%' . $request->q . '%');
                })
                ->orWhere('folio', 'like', '%' . $request->q . '%')
                ->orWhere('monto', 'like', '%' . $request->q . '%');
            });
        }
        
        $prestamos = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('modules.prestamos.index', compact('prestamos'));
    }

    public function create(Request $request) {
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::where('estado', 'disponible')->with('almacen')->get();
        $almacenes = Almacen::all();
        $intereses = Interes::all();
        $cliente_id = $request->cliente_id;
        return view('modules.prestamos.create', compact('clientes', 'productos', 'almacenes', 'intereses', 'cliente_id'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_prestamo' => 'required|date',
            'prendas' => 'required|array|min:1',
        ]);

        $almacen = Almacen::first();
        $interes = $request->interes_id ? Interes::find($request->interes_id) : null;
        $interes_mensual = $interes ? $interes->porcentaje : 0;
        
        // Calcular monto total de valuaciones
        $monto_total = 0;
        foreach ($request->prendas as $prendaData) {
            $monto_total += floatval($prendaData['valuacion'] ?? 0);
        }

        $plazo_dias = 30;
        $monto_interes = ($monto_total * $interes_mensual / 100) * ($plazo_dias / 30);
        $monto_con_interes = $monto_total + $monto_interes;

        $prestamo = Prestamo::create([
            'cliente_id' => $validated['cliente_id'],
            'almacen_id' => $almacen->id,
            'interes_id' => $request->interes_id,
            'monto' => $monto_total,
            'interes_mensual' => $interes_mensual,
            'monto_total' => $monto_con_interes,
            'monto_pagado' => 0,
            'monto_pendiente' => $monto_con_interes,
            'fecha_prestamo' => $validated['fecha_prestamo'],
            'fecha_vencimiento' => date('Y-m-d', strtotime($validated['fecha_prestamo'] . ' + ' . $plazo_dias . ' days')),
            'plazo_dias' => $plazo_dias,
            'estado' => 'activo',
        ]);

        // Registrar operación inicial
        PrestamoOperacion::create([
            'prestamo_id' => $prestamo->id,
            'tipo' => 'prestamo',
            'cargo' => $monto_total,
            'abono' => 0,
            'saldo' => $monto_total,
            'usuario_id' => auth()->id(),
            'descripcion' => 'Préstamo'
        ]);

        // Registrar en flujo de caja
        \App\Models\CashFlow::create([
            'fecha' => now(),
            'usuario_id' => auth()->id(),
            'concepto' => 'Préstamo',
            'detalles' => 'Préstamo #' . $prestamo->id . ' - ' . $prestamo->cliente->nombre,
            'monto' => $monto_total,
            'tipo_movimiento' => 'salida',
            'branch_id' => $almacen->id
        ]);

        // Registrar intereses generados
        PrestamoOperacion::create([
            'prestamo_id' => $prestamo->id,
            'tipo' => 'interes_generado',
            'cargo' => $monto_interes,
            'abono' => 0,
            'saldo' => $monto_con_interes,
            'descripcion' => 'Intereses generados'
        ]);

        // Crear productos dinámicamente
        foreach ($request->prendas as $prendaData) {
            $producto = Producto::create([
                'nombre' => $prendaData['descripcion'] ?? $prendaData['marca'] ?? 'Prenda',
                'tipo' => $prendaData['tipo'],
                'marca' => $prendaData['marca'] ?? null,
                'modelo' => $prendaData['modelo'] ?? null,
                'numero_serie' => $prendaData['numero_serie'] ?? null,
                'descripcion' => $prendaData['observaciones'] ?? null,
                'peso' => $prendaData['peso'] ?? null,
                'quilates' => $prendaData['quilates'] ?? null,
                'avaluo' => $prendaData['avaluo'] ?? null,
                'valuacion' => $prendaData['valuacion'],
                'estado' => 'empeñado',
                'almacen_id' => $almacen->id,
            ]);
            
            $prestamo->productos()->attach($producto->id, ['valuacion' => $prendaData['valuacion']]);
        }

        return redirect()->route('prestamos.show', $prestamo->id)
            ->with('success', 'Préstamo registrado exitosamente');
    }

    public function show($id) {
        $prestamo = Prestamo::with(['cliente', 'productos', 'almacen', 'interes', 'pagos', 'operaciones.usuario'])->findOrFail($id);
        return view('modules.prestamos.show', compact('prestamo'));
    }

    public function pdf($id) {
        $prestamo = Prestamo::with(['cliente', 'productos', 'almacen'])->findOrFail($id);
        $pdf = Pdf::loadView('modules.prestamos.pdf', compact('prestamo'));
        return $pdf->download('boleta-' . $prestamo->folio . '.pdf');
    }

    public function registrarPago(Request $request, $id) {
        $prestamo = Prestamo::findOrFail($id);
        
        $validated = $request->validate([
            'monto' => 'required|numeric|min:0',
            'tipo' => 'required|in:refrendo,abono_capital,liquidacion',
        ]);

        $interes_pendiente = $prestamo->monto_total - $prestamo->monto;
        $capital_pendiente = $prestamo->monto;
        
        $interes_pagado = 0;
        $capital_pagado = 0;

        if ($validated['tipo'] === 'refrendo') {
            $interes_pagado = min($validated['monto'], $interes_pendiente);
        } elseif ($validated['tipo'] === 'abono_capital') {
            $interes_pagado = min($validated['monto'], $interes_pendiente);
            $capital_pagado = max(0, $validated['monto'] - $interes_pendiente);
        } else {
            $interes_pagado = $interes_pendiente;
            $capital_pagado = $capital_pendiente;
        }

        $pago = Pago::create([
            'prestamo_id' => $prestamo->id,
            'tipo' => $validated['tipo'],
            'monto' => $validated['monto'],
            'interes_pagado' => $interes_pagado,
            'capital_pagado' => $capital_pagado,
            'fecha_pago' => now(),
            'usuario_id' => auth()->id(),
            'notas' => $request->notas,
        ]);

        $prestamo->monto_pagado += $validated['monto'];
        $prestamo->monto_pendiente -= $validated['monto'];

        // Registrar operación
        $saldo_actual = $prestamo->monto_pendiente;
        PrestamoOperacion::create([
            'prestamo_id' => $prestamo->id,
            'tipo' => 'pago',
            'cargo' => 0,
            'abono' => $validated['monto'],
            'saldo' => $saldo_actual,
            'usuario_id' => auth()->id(),
            'descripcion' => ucfirst($validated['tipo'])
        ]);

        // Registrar en flujo de caja
        \App\Models\CashFlow::create([
            'fecha' => now(),
            'usuario_id' => auth()->id(),
            'concepto' => $validated['tipo'] === 'refrendo' ? 'Pago de intereses' : ($validated['tipo'] === 'liquidacion' ? 'Cancelación de préstamo' : 'Abono a capital'),
            'detalles' => 'Préstamo #' . $prestamo->id,
            'monto' => $validated['monto'],
            'tipo_movimiento' => 'entrada',
            'branch_id' => $prestamo->almacen_id
        ]);

        if ($prestamo->monto_pendiente <= 0) {
            $prestamo->estado = 'liquidado';
            foreach ($prestamo->productos as $producto) {
                $producto->update(['estado' => 'disponible']);
            }
        }

        $prestamo->save();

        return redirect()->route('prestamos.show', $prestamo->id)
            ->with('success', 'Pago registrado exitosamente');
    }

    public function cancelar($id) {
        $prestamo = Prestamo::findOrFail($id);
        $prestamo->update(['estado' => 'cancelado']);
        
        PrestamoOperacion::create([
            'prestamo_id' => $prestamo->id,
            'tipo' => 'cancelacion',
            'cargo' => 0,
            'abono' => 0,
            'saldo' => 0,
            'usuario_id' => auth()->id(),
            'descripcion' => 'Cancelado'
        ]);

        foreach ($prestamo->productos as $producto) {
            $producto->update(['estado' => 'disponible']);
        }

        return redirect()->route('prestamos.show', $prestamo->id)
            ->with('success', 'Préstamo cancelado');
    }

    public function expirar($id) {
        $prestamo = Prestamo::findOrFail($id);
        $prestamo->update(['estado' => 'expirado']);
        
        PrestamoOperacion::create([
            'prestamo_id' => $prestamo->id,
            'tipo' => 'cancelacion',
            'cargo' => 0,
            'abono' => 0,
            'saldo' => $prestamo->monto_pendiente,
            'usuario_id' => auth()->id(),
            'descripcion' => 'Expirado'
        ]);

        // Cuando expira, las prendas pasan a venta
        foreach ($prestamo->productos as $producto) {
            $producto->update(['estado' => 'en_venta']);
        }

        return redirect()->route('prestamos.show', $prestamo->id)
            ->with('success', 'Préstamo marcado como expirado');
    }

    public function aplicarDescuento(Request $request, $id) {
        $prestamo = Prestamo::findOrFail($id);
        
        $validated = $request->validate([
            'monto' => 'required|numeric|min:0',
        ]);

        $prestamo->monto_pendiente -= $validated['monto'];
        $prestamo->save();

        PrestamoOperacion::create([
            'prestamo_id' => $prestamo->id,
            'tipo' => 'descuento',
            'cargo' => 0,
            'abono' => $validated['monto'],
            'saldo' => $prestamo->monto_pendiente,
            'usuario_id' => auth()->id(),
            'descripcion' => 'Descuento aplicado'
        ]);

        return redirect()->route('prestamos.show', $prestamo->id)
            ->with('success', 'Descuento aplicado');
    }

    public function update(Request $request, $id) {
        $prestamo = Prestamo::findOrFail($id);
        $prestamo->update($request->all());
        return response()->json($prestamo);
    }

    public function destroy($id) {
        Prestamo::destroy($id);
        return response()->json(null, 204);
    }
}
