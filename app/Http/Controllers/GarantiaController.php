<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Aval;
use App\Models\SeguroPrenda;
use App\Models\GarantiaCruzada;

class GarantiaController extends Controller
{
    public function agregarAval(Request $request, $prestamoId)
    {
        $validated = $request->validate([
            'cliente_aval_id' => 'required|exists:clientes,id',
            'tipo_aval' => 'required|in:solidario,simple,mancomunado',
            'monto_garantizado' => 'required|numeric|min:0',
            'fecha_constitucion' => 'required|date',
            'observaciones' => 'nullable|string'
        ]);

        Aval::create([
            'prestamo_id' => $prestamoId,
            ...$validated
        ]);

        return redirect()->back()->with('success', 'Aval agregado exitosamente');
    }

    public function agregarSeguro(Request $request, $prestamoId)
    {
        $validated = $request->validate([
            'aseguradora' => 'required|string',
            'numero_poliza' => 'required|string',
            'valor_asegurado' => 'required|numeric|min:0',
            'prima' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_vencimiento' => 'required|date|after:fecha_inicio',
            'cobertura' => 'nullable|string'
        ]);

        SeguroPrenda::create([
            'prestamo_id' => $prestamoId,
            ...$validated
        ]);

        return redirect()->back()->with('success', 'Seguro agregado exitosamente');
    }

    public function agregarCruzada(Request $request, $prestamoId)
    {
        $validated = $request->validate([
            'prestamo_garantia_id' => 'required|exists:prestamos,id',
            'porcentaje_garantia' => 'required|numeric|min:0|max:100',
            'condiciones' => 'nullable|string'
        ]);

        GarantiaCruzada::create([
            'prestamo_principal_id' => $prestamoId,
            ...$validated
        ]);

        return redirect()->back()->with('success', 'Garantía cruzada agregada exitosamente');
    }
}