<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Almacen;
use App\Models\FotoEquipo;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CompraController extends Controller
{
    public function index(Request $request) {
        $query = Compra::with(['cliente', 'producto', 'almacen']);
        
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

    public function create(Request $request) {
        $clientes = Cliente::orderBy('nombre')->get();
        $almacenes = Almacen::orderBy('id')->get();
        $cliente_id = $request->get('cliente_id');
        return view('modules.compras.create', compact('clientes', 'almacenes', 'cliente_id'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'almacen_id' => 'required|exists:almacenes,id',
            'tipo_compra' => 'required|in:venta_directa,liquidacion,adquisicion',
            'nombre_producto' => 'required|string|max:255',
            'tipo' => 'required|string',
            'precio_compra' => 'required|numeric|min:0',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Crear el producto
        $producto = Producto::create([
            'nombre' => $request->nombre_producto,
            'tipo' => $request->tipo,
            'categoria' => $request->categoria,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'numero_serie' => $request->numero_serie,
            'descripcion' => $request->descripcion,
            'peso' => $request->peso,
            'quilates' => $request->quilates,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'valuacion' => $request->precio_compra,
            'estado' => 'disponible',
            'almacen_id' => $request->almacen_id,
        ]);

        // Crear la compra
        $compra = Compra::create([
            'cliente_id' => $request->cliente_id,
            'producto_id' => $producto->id,
            'almacen_id' => $request->almacen_id,
            'monto' => $request->precio_compra,
            'fecha_compra' => now(),
            'estado' => 'COMPLETADA',
            'tipo_compra' => $request->tipo_compra,
            'observaciones' => $request->observaciones,
        ]);

        // Subir fotos si existen
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $nombreArchivo = 'producto_' . $producto->id . '_' . time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                $ruta = $foto->storeAs('public/productos_fotos', $nombreArchivo);
                
                FotoEquipo::create([
                    'equipo_id' => $producto->id,
                    'ruta' => 'productos_fotos/' . $nombreArchivo,
                    'descripcion' => 'Foto del producto ' . $producto->nombre
                ]);
            }
        }

        // Registrar en flujo de caja
        \App\Models\CashFlow::create([
            'fecha' => now(),
            'usuario_id' => auth()->id(),
            'concepto' => 'Compra',
            'detalles' => 'Compra #' . $compra->id . ' - ' . $producto->nombre . ' de ' . $compra->cliente->nombre,
            'monto' => $request->precio_compra,
            'tipo_movimiento' => 'salida'
        ]);

        return redirect()->route('compras.show', $compra->id)->with('success', 'Compra registrada exitosamente');
    }

    public function show($id) {
        $compra = Compra::with(['cliente', 'producto', 'almacen'])->findOrFail($id);
        return view('modules.compras.show', compact('compra'));
    }

    public function update(Request $request, $id) {
        $compra = Compra::findOrFail($id);
        $compra->update($request->only(['estado', 'observaciones']));
        return response()->json($compra);
    }

    public function generarContrato($id) {
        $compra = Compra::with(['cliente', 'producto', 'almacen'])->findOrFail($id);
        
        $pdf = Pdf::loadView('modules.compras.contrato', compact('compra'));
        $pdf->setPaper('letter', 'portrait');
        
        return $pdf->stream('Documento_Privado_Compra_' . $compra->id . '.pdf');
    }

    public function descargarContrato($id) {
        $compra = Compra::with(['cliente', 'producto', 'almacen'])->findOrFail($id);
        
        $pdf = Pdf::loadView('modules.compras.contrato', compact('compra'));
        $pdf->setPaper('letter', 'portrait');
        
        return $pdf->download('Documento_Privado_Compra_' . $compra->id . '.pdf');
    }
}
