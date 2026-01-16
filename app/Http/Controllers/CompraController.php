<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Almacen;

class CompraController extends Controller
{
    public function index(Request $request) {
        $query = Compra::with(['cliente', 'producto']);
        
        if ($request->desde) {
            $query->whereDate('fecha_compra', '>=', $request->desde);
        }
        if ($request->hasta) {
            $query->whereDate('fecha_compra', '<=', $request->hasta);
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
        
        $compras = $query->orderBy('created_at', 'desc')->get();
        return view('modules.compras.index', compact('compras'));
    }

    public function create() {
        $clientes = Cliente::orderBy('nombre')->get();
        $almacenes = Almacen::all();
        return view('modules.compras.create', compact('clientes', 'almacenes'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'almacen_id' => 'required|exists:almacenes,id',
            'nombre_producto' => 'required|string',
            'tipo' => 'required|string',
            'precio_compra' => 'required|numeric|min:0',
        ]);

        $producto = Producto::create([
            'nombre' => $request->nombre_producto,
            'tipo' => $request->tipo,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'descripcion' => $request->descripcion,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'valuacion' => $request->precio_compra,
            'estado' => 'disponible',
            'almacen_id' => $request->almacen_id,
        ]);

        $compra = Compra::create([
            'cliente_id' => $request->cliente_id,
            'producto_id' => $producto->id,
            'monto' => $request->precio_compra,
            'fecha_compra' => now(),
            'observaciones' => $request->observaciones,
        ]);

        // Registrar en flujo de caja
        \App\Models\CashFlow::create([
            'fecha' => now(),
            'usuario_id' => auth()->id(),
            'concepto' => 'Compra',
            'detalles' => 'Compra #' . $compra->id . ' - ' . $producto->nombre,
            'monto' => $request->precio_compra,
            'tipo_movimiento' => 'salida',
            'branch_id' => $request->almacen_id
        ]);

        return redirect()->route('compras.index')->with('success', 'Compra registrada exitosamente');
    }

    public function show($id) {
        $compra = Compra::with(['cliente', 'producto'])->findOrFail($id);
        return view('modules.compras.show', compact('compra'));
    }

    public function update(Request $request, $id) {
        $compra = Compra::findOrFail($id);
        $compra->update($request->all());
        return response()->json($compra);
    }

    public function destroy($id) {
        Compra::destroy($id);
        return response()->json(null, 204);
    }
}
