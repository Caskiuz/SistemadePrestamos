<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transferencia;
use App\Models\Producto;
use App\Models\Almacen;
use App\Models\ConsolidadoSucursal;

class TransferenciaController extends Controller
{
    public function index()
    {
        $transferencias = Transferencia::with(['almacenOrigen', 'almacenDestino', 'producto'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('modules.transferencias.index', compact('transferencias'));
    }

    public function create()
    {
        $almacenes = Almacen::all();
        $productos = Producto::whereIn('estado', ['disponible', 'en_venta'])->get();
        
        return view('modules.transferencias.create', compact('almacenes', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'almacen_destino_id' => 'required|exists:almacenes,id',
            'producto_id' => 'required|exists:productos,id',
            'motivo' => 'required|string',
            'observaciones' => 'nullable|string'
        ]);

        $producto = Producto::findOrFail($validated['producto_id']);

        Transferencia::create([
            ...$validated,
            'almacen_origen_id' => $producto->almacen_id,
            'fecha_envio' => now(),
            'usuario_envia_id' => auth()->id()
        ]);

        return redirect()->route('transferencias.index')
            ->with('success', 'Transferencia iniciada');
    }

    public function recibir($id)
    {
        $transferencia = Transferencia::findOrFail($id);
        
        if ($transferencia->estado !== 'pendiente') {
            return redirect()->back()->with('error', 'Transferencia ya procesada');
        }

        // Actualizar producto
        $transferencia->producto->update([
            'almacen_id' => $transferencia->almacen_destino_id
        ]);

        // Completar transferencia
        $transferencia->update([
            'estado' => 'completada',
            'fecha_recepcion' => now(),
            'usuario_recibe_id' => auth()->id()
        ]);

        return redirect()->route('transferencias.index')
            ->with('success', 'Transferencia completada');
    }

    public function consolidado()
    {
        $almacenes = Almacen::with(['prestamos' => function($q) {
            $q->where('estado', 'activo');
        }, 'productos'])->get();

        $consolidados = $almacenes->map(function($almacen) {
            $prestamosActivos = $almacen->prestamos->count();
            $montoActivo = $almacen->prestamos->sum('monto_pendiente');
            $productosInventario = $almacen->productos->count();
            $valorInventario = $almacen->productos->sum('valuacion');

            return [
                'almacen' => $almacen,
                'prestamos_activos' => $prestamosActivos,
                'monto_activo' => $montoActivo,
                'productos_inventario' => $productosInventario,
                'valor_inventario' => $valorInventario
            ];
        });

        return view('modules.transferencias.consolidado', compact('consolidados'));
    }
}