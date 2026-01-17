<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartado;
use App\Models\Cliente;
use App\Models\Producto;

class ApartadoController extends Controller
{
    public function index(Request $request) {
        $query = Apartado::with(['cliente', 'producto']);
        
        if ($request->status) {
            $query->where('estado', $request->status);
        }
        
        $apartados = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('modules.apartados.index', compact('apartados'));
    }

    public function create() {
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::whereIn('estado', ['disponible', 'en_venta'])->with('almacen')->get();
        return view('modules.apartados.create', compact('clientes', 'productos'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'monto_total' => 'required|numeric|min:0',
            'anticipo' => 'required|numeric|min:0',
            'plazo_dias' => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        
        $apartado = Apartado::create([
            'cliente_id' => $validated['cliente_id'],
            'producto_id' => $validated['producto_id'],
            'monto_total' => $validated['monto_total'],
            'anticipo' => $validated['anticipo'],
            'saldo' => $validated['monto_total'] - $validated['anticipo'],
            'plazo_dias' => $validated['plazo_dias'],
            'fecha_apartado' => now(),
            'fecha_vencimiento' => now()->addDays($validated['plazo_dias']),
            'estado' => 'activo',
            'observaciones' => $request->observaciones,
        ]);

        $producto->update(['estado' => 'apartado']);

        return redirect()->route('apartados.show', $apartado->id)
            ->with('success', 'Apartado registrado exitosamente');
    }

    public function show($id) {
        $apartado = Apartado::with(['cliente', 'producto'])->findOrFail($id);
        return view('modules.apartados.show', compact('apartado'));
    }

    public function update(Request $request, $id) {
        $apartado = Apartado::findOrFail($id);
        $apartado->update($request->all());
        return response()->json($apartado);
    }

    public function destroy($id) {
        Apartado::destroy($id);
        return response()->json(null, 204);
    }
}
