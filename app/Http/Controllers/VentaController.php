<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;

class VentaController extends Controller
{
    public function index(Request $request) {
        $query = Venta::with(['cliente', 'producto']);
        
        if ($request->desde) {
            $query->whereDate('fecha_venta', '>=', $request->desde);
        }
        if ($request->hasta) {
            $query->whereDate('fecha_venta', '<=', $request->hasta);
        }
        
        if ($request->q) {
            $query->where(function($q) use ($request) {
                $q->whereHas('cliente', function($subQ) use ($request) {
                    $subQ->where('nombre', 'like', '%' . $request->q . '%');
                });
            });
        }
        
        $ventas = $query->orderBy('created_at', 'desc')->get();
        return view('modules.ventas.index', compact('ventas'));
    }

    public function create() {
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::whereIn('estado', ['disponible', 'en_venta'])->with('almacen')->get();
        return view('modules.ventas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'monto' => 'required|numeric|min:0',
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        
        $venta = Venta::create([
            'cliente_id' => $validated['cliente_id'],
            'producto_id' => $validated['producto_id'],
            'monto' => $validated['monto'],
            'fecha_venta' => now(),
            'observaciones' => $request->observaciones,
        ]);

        $producto->update(['estado' => 'vendido']);

        // Registrar en flujo de caja
        \App\Models\CashFlow::create([
            'fecha' => now(),
            'usuario_id' => auth()->id(),
            'concepto' => 'Venta',
            'detalles' => 'Venta #' . $venta->id . ' - ' . $producto->nombre,
            'monto' => $validated['monto'],
            'tipo_movimiento' => 'entrada',
            'branch_id' => $producto->almacen_id
        ]);

        return redirect()->route('ventas.index')->with('success', 'Venta registrada exitosamente');
    }

    public function show($id) {
        $venta = Venta::with(['cliente', 'producto'])->findOrFail($id);
        return view('modules.ventas.show', compact('venta'));
    }

    public function update(Request $request, $id) {
        $venta = Venta::findOrFail($id);
        $venta->update($request->all());
        return response()->json($venta);
    }

    public function destroy($id) {
        Venta::destroy($id);
        return response()->json(null, 204);
    }
}
