<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Almacen;

class ProductoController extends Controller
{
    public function inventarioIndex(Request $request) {
        $query = Producto::with(['almacen', 'fotos']);
        
        if ($request->status) {
            // Mapear status de URL a estados de BD
            $statusMap = [
                'loan' => 'empeñado',
                'forSale' => 'en_venta',
                'layaway' => 'apartado',
                'sold' => 'vendido',
                'available' => 'disponible'
            ];
            
            $estado = $statusMap[$request->status] ?? $request->status;
            $query->where('estado', $estado);
        } else {
            // Por defecto mostrar solo productos en venta
            $query->where('estado', 'en_venta');
        }
        
        if ($request->q) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->q . '%')
                  ->orWhere('categoria', 'like', '%' . $request->q . '%');
            });
        }
        
        $productos = $query->paginate(10);
        return view('modules.inventario.index', compact('productos'));
    }

    public function create() {
        $almacenes = Almacen::all();
        return view('modules.inventario.create-new', compact('almacenes'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string',
            'almacen_id' => 'required|exists:almacenes,id',
            'valuacion' => 'required|numeric|min:0',
            'estado' => 'required|in:disponible,empeñado,vendido,apartado,en_venta',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('productos', 'public');
        }

        $producto = Producto::create($data);
        return redirect()->route('inventario.index')->with('success', 'Producto creado exitosamente');
    }

    public function inventarioShow($id) {
        $producto = Producto::with(['almacen', 'prestamos.cliente', 'fotos'])->findOrFail($id);
        return view('modules.inventario.show', compact('producto'));
    }

    public function edit($id) {
        $producto = Producto::with(['fotos'])->findOrFail($id);
        $almacenes = Almacen::all();
        return view('modules.inventario.edit', compact('producto', 'almacenes'));
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string',
            'almacen_id' => 'required|exists:almacenes,id',
            'valuacion' => 'required|numeric|min:0',
            'estado' => 'required|in:disponible,empeñado,vendido,apartado,en_venta',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($validated + $request->only([
            'categoria', 'marca', 'modelo', 'numero_serie', 'peso', 'quilates',
            'precio_compra', 'precio_venta', 'descripcion'
        ]));
        
        return redirect()->route('inventario.show', $producto->id)
            ->with('success', 'Producto actualizado exitosamente');
    }

    public function subirFoto(Request $request, $id) {
        try {
            $request->validate([
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240'
            ]);

            $producto = Producto::findOrFail($id);
            
            // Eliminar fotos anteriores (tanto campo foto como fotos múltiples)
            if ($producto->foto) {
                // Eliminar foto individual anterior
                if (str_starts_with($producto->foto, 'productos/')) {
                    $rutaAnterior = storage_path('app/public/' . $producto->foto);
                } else {
                    $rutaAnterior = public_path($producto->foto);
                }
                if (file_exists($rutaAnterior)) {
                    unlink($rutaAnterior);
                }
                $producto->update(['foto' => null]);
            }
            
            // Eliminar fotos múltiples anteriores
            foreach ($producto->fotos as $foto) {
                $rutaArchivo = public_path($foto->ruta);
                if (file_exists($rutaArchivo)) {
                    unlink($rutaArchivo);
                }
                $foto->delete();
            }
            
            // Subir nueva foto al sistema unificado (public/fotos)
            $foto = $request->file('foto');
            $extension = $foto->getClientOriginalExtension() ?: 'jpg';
            $nombreArchivo = 'producto_' . $id . '_' . time() . '_' . uniqid() . '.' . $extension;
            
            // Mover archivo directamente a public/fotos
            $destinoPath = public_path('fotos');
            if (!file_exists($destinoPath)) {
                mkdir($destinoPath, 0755, true);
            }
            
            $foto->move($destinoPath, $nombreArchivo);
            
            // Guardar en el sistema de fotos múltiples (unificado)
            \App\Models\FotoEquipo::create([
                'equipo_id' => $producto->id,
                'ruta' => 'fotos/' . $nombreArchivo,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Foto actualizada exitosamente',
                'foto_url' => asset('fotos/' . $nombreArchivo)
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al subir foto de producto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la foto: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminarFoto($id) {
        try {
            $producto = Producto::with('fotos')->findOrFail($id);
            
            // Eliminar todas las fotos del producto
            foreach ($producto->fotos as $foto) {
                // Eliminar archivo físico
                $rutaArchivo = public_path($foto->ruta);
                if (file_exists($rutaArchivo)) {
                    unlink($rutaArchivo);
                }
                // Eliminar registro
                $foto->delete();
            }
            
            // Limpiar campo foto individual si existe
            if ($producto->foto) {
                if (str_starts_with($producto->foto, 'productos/')) {
                    $rutaArchivo = storage_path('app/public/' . $producto->foto);
                } else {
                    $rutaArchivo = public_path($producto->foto);
                }
                if (file_exists($rutaArchivo)) {
                    unlink($rutaArchivo);
                }
                $producto->update(['foto' => null]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Fotos eliminadas exitosamente'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar fotos de producto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar las fotos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id) {
        Producto::destroy($id);
        return redirect()->route('inventario.index')->with('success', 'Producto eliminado exitosamente');
    }
}
