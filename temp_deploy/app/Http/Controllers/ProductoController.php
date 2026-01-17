<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Almacen;

class ProductoController extends Controller
{
    public function inventarioIndex(Request $request) {
        $query = Producto::with('almacen');
        
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
        $producto = Producto::with(['almacen', 'prestamos.cliente'])->findOrFail($id);
        return view('modules.inventario.show', compact('producto'));
    }

    public function edit($id) {
        $producto = Producto::findOrFail($id);
        $almacenes = Almacen::all();
        return view('modules.inventario.edit', compact('producto', 'almacenes'));
    }

    public function update(Request $request, $id) {
        $producto = Producto::findOrFail($id);
        $producto->update($request->all());
        return redirect()->route('inventario.index')->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy($id) {
        Producto::destroy($id);
        return redirect()->route('inventario.index')->with('success', 'Producto eliminado exitosamente');
    }
}
