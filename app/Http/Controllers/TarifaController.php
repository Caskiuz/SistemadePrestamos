<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarifa;
use App\Models\Comision;
use App\Models\Prestamo;

class TarifaController extends Controller
{
    public function index()
    {
        $tarifas = Tarifa::orderBy('nombre')->get();
        return view('modules.tarifas.index', compact('tarifas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:porcentaje,fijo',
            'valor' => 'required|numeric|min:0',
            'aplicacion' => 'required|in:prestamo,almacenamiento,mora,servicio',
            'descripcion' => 'nullable|string'
        ]);

        Tarifa::create($validated);
        return redirect()->route('tarifas.index')->with('success', 'Tarifa creada');
    }

    public function aplicarComision(Request $request, $prestamoId)
    {
        $prestamo = Prestamo::findOrFail($prestamoId);
        
        $validated = $request->validate([
            'tarifa_id' => 'required|exists:tarifas,id',
            'concepto' => 'required|string'
        ]);

        $tarifa = Tarifa::findOrFail($validated['tarifa_id']);
        $monto = $tarifa->calcularMonto($prestamo->monto);

        Comision::create([
            'prestamo_id' => $prestamo->id,
            'tarifa_id' => $tarifa->id,
            'monto' => $monto,
            'fecha_aplicacion' => now(),
            'concepto' => $validated['concepto'],
            'usuario_id' => auth()->id()
        ]);

        // Agregar al monto pendiente
        $prestamo->increment('monto_pendiente', $monto);
        $prestamo->increment('monto_total', $monto);

        return redirect()->route('prestamos.show', $prestamo->id)
            ->with('success', 'Comisión aplicada');
    }
}