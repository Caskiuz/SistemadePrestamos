<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Almacen;
use Barryvdh\DomPDF\Facade\Pdf;

class VentaController extends Controller
{
    public function index(Request $request) {
        $query = Venta::with(['cliente', 'producto', 'almacen']);
        
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
                })
                ->orWhereHas('producto', function($subQ) use ($request) {
                    $subQ->where('nombre', 'like', '%' . $request->q . '%');
                });
            });
        }
        
        $ventas = $query->orderBy('created_at', 'desc')->get();
        return view('modules.ventas.index', compact('ventas'));
    }

    public function create(Request $request) {
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::whereIn('estado', ['disponible', 'en_venta'])
                            ->with(['almacen', 'compras'])
                            ->get();
        $cliente_id = $request->get('cliente_id');
        return view('modules.ventas.create', compact('clientes', 'productos', 'cliente_id'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'monto' => 'required|numeric|min:0',
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        
        // Validar que el producto esté disponible para venta
        if (!in_array($producto->estado, ['disponible', 'en_venta'])) {
            return back()->withErrors(['producto_id' => 'Este producto no está disponible para venta.']);
        }
        
        $venta = Venta::create([
            'cliente_id' => $validated['cliente_id'],
            'producto_id' => $validated['producto_id'],
            'almacen_id' => $producto->almacen_id,
            'monto' => $validated['monto'],
            'fecha_venta' => now(),
            'estado' => 'COMPLETADA',
            'observaciones' => $request->observaciones,
        ]);

        // Cambiar estado del producto
        $producto->update(['estado' => 'vendido']);

        // Registrar en flujo de caja
        \App\Models\CashFlow::create([
            'fecha' => now(),
            'usuario_id' => auth()->id(),
            'concepto' => 'Venta',
            'detalles' => 'Venta #' . $venta->id . ' - ' . $producto->nombre . ' a ' . $venta->cliente->nombre,
            'monto' => $validated['monto'],
            'tipo_movimiento' => 'entrada'
        ]);

        return redirect()->route('ventas.show', $venta->id)->with('success', 'Venta registrada exitosamente');
    }

    public function show($id) {
        $venta = Venta::with(['cliente', 'producto', 'almacen'])->findOrFail($id);
        return view('modules.ventas.show', compact('venta'));
    }

    public function factura($id) {
        $venta = Venta::with(['cliente', 'producto', 'almacen'])->findOrFail($id);
        $pdf = Pdf::loadView('modules.ventas.factura', compact('venta'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Factura_Venta_' . $venta->id . '.pdf');
    }

    public function facturaDownload($id) {
        $venta = Venta::with(['cliente', 'producto', 'almacen'])->findOrFail($id);
        $pdf = Pdf::loadView('modules.ventas.factura', compact('venta'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->download('Factura_Venta_' . $venta->id . '.pdf');
    }

    public function update(Request $request, $id) {
        $venta = Venta::findOrFail($id);
        $venta->update($request->only(['estado', 'observaciones']));
        return response()->json($venta);
    }

    public function destroy($id) {
        $venta = Venta::findOrFail($id);
        
        // Devolver producto a disponible
        $venta->producto->update(['estado' => 'disponible']);
        
        $venta->delete();
        return response()->json(['message' => 'Venta eliminada exitosamente']);
    }
}