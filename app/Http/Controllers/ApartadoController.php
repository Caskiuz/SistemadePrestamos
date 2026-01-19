<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartado;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Almacen;

class ApartadoController extends Controller
{
    public function index(Request $request) {
        $query = Apartado::with(['cliente', 'producto', 'almacen']);
        
        // Actualizar apartados vencidos automáticamente
        Apartado::where('estado', 'VIGENTE')
            ->whereDate('fecha_vencimiento', '<', now())
            ->update(['estado' => 'VENCIDO']);
        
        if ($request->estado) {
            $query->where('estado', $request->estado);
        }
        
        if ($request->desde) {
            $query->whereDate('fecha_apartado', '>=', $request->desde);
        }
        if ($request->hasta) {
            $query->whereDate('fecha_apartado', '<=', $request->hasta);
        }
        
        if ($request->q) {
            $query->where(function($q) use ($request) {
                $q->whereHas('cliente', function($subQ) use ($request) {
                    $subQ->where('nombre', 'like', '%' . $request->q . '%');
                })
                ->orWhereHas('producto', function($subQ) use ($request) {
                    $subQ->where('nombre', 'like', '%' . $request->q . '%');
                });
            });
        }
        
        $apartados = $query->orderBy('created_at', 'desc')->get();
        return view('modules.apartados.index', compact('apartados'));
    }

    public function create(Request $request) {
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::whereIn('estado', ['disponible', 'en_venta'])
                            ->with('almacen')
                            ->get();
        $cliente_id = $request->get('cliente_id');
        return view('modules.apartados.create', compact('clientes', 'productos', 'cliente_id'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'monto_total' => 'required|numeric|min:0',
            'anticipo' => 'required|numeric|min:0',
            'plazo_dias' => 'required|integer|min:1|max:90',
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        
        // Validar que el producto esté disponible
        if (!in_array($producto->estado, ['disponible', 'en_venta'])) {
            return back()->withErrors(['producto_id' => 'Este producto no está disponible para apartar.']);
        }
        
        // Validar que el anticipo no sea mayor al monto total
        if ($validated['anticipo'] > $validated['monto_total']) {
            return back()->withErrors(['anticipo' => 'El anticipo no puede ser mayor al monto total.']);
        }
        
        $saldo = $validated['monto_total'] - $validated['anticipo'];
        
        $apartado = Apartado::create([
            'cliente_id' => $validated['cliente_id'],
            'producto_id' => $validated['producto_id'],
            'almacen_id' => $producto->almacen_id,
            'monto_total' => $validated['monto_total'],
            'anticipo' => $validated['anticipo'],
            'saldo' => $saldo,
            'fecha_apartado' => now(),
            'fecha_vencimiento' => now()->addDays($validated['plazo_dias']),
            'estado' => 'VIGENTE',
            'observaciones' => $request->observaciones,
        ]);

        // Cambiar estado del producto
        $producto->update(['estado' => 'apartado']);

        // Registrar anticipo en flujo de caja
        \App\Models\CashFlow::create([
            'fecha' => now(),
            'usuario_id' => auth()->id(),
            'concepto' => 'Apartado - Anticipo',
            'detalles' => 'Apartado #' . $apartado->id . ' - ' . $producto->nombre . ' de ' . $apartado->cliente->nombre,
            'monto' => $validated['anticipo'],
            'tipo_movimiento' => 'entrada'
        ]);

        return redirect()->route('apartados.index')
            ->with('success', 'Apartado registrado exitosamente');
    }

    public function show($id) {
        $apartado = Apartado::with(['cliente', 'producto', 'almacen'])->findOrFail($id);
        return view('modules.apartados.show', compact('apartado'));
    }

    public function completar(Request $request, $id) {
        $apartado = Apartado::findOrFail($id);
        
        if ($apartado->estado !== 'VIGENTE') {
            return back()->withErrors(['error' => 'Solo se pueden completar apartados vigentes.']);
        }
        
        // Registrar pago del saldo
        if ($apartado->saldo > 0) {
            \App\Models\CashFlow::create([
                'fecha' => now(),
                'usuario_id' => auth()->id(),
                'concepto' => 'Apartado - Saldo Final',
                'detalles' => 'Completar apartado #' . $apartado->id . ' - ' . $apartado->producto->nombre,
                'monto' => $apartado->saldo,
                'tipo_movimiento' => 'entrada'
            ]);
        }
        
        // Actualizar apartado y producto
        $apartado->update(['estado' => 'COMPLETADO']);
        $apartado->producto->update(['estado' => 'vendido']);
        
        return redirect()->route('apartados.show', $apartado->id)
            ->with('success', 'Apartado completado exitosamente');
    }

    public function cancelar($id) {
        $apartado = Apartado::findOrFail($id);
        
        if (!in_array($apartado->estado, ['VIGENTE', 'VENCIDO'])) {
            return back()->withErrors(['error' => 'No se puede cancelar este apartado.']);
        }
        
        // Devolver producto a disponible
        $apartado->producto->update(['estado' => 'disponible']);
        $apartado->update(['estado' => 'CANCELADO']);
        
        return redirect()->route('apartados.index')
            ->with('success', 'Apartado cancelado exitosamente');
    }

    public function destroy($id) {
        $apartado = Apartado::findOrFail($id);
        
        // Devolver producto a disponible si no está completado
        if ($apartado->estado !== 'COMPLETADO') {
            $apartado->producto->update(['estado' => 'disponible']);
        }
        
        $apartado->delete();
        return response()->json(['message' => 'Apartado eliminado exitosamente']);
    }
}
