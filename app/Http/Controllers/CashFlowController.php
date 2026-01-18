<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashFlow;
use App\Models\Ingreso;
use App\Models\Egreso;
use Carbon\Carbon;

class CashFlowController extends Controller
{
    public function index(Request $request)
    {
        $fecha_desde = $request->get('desde', now()->format('Y-m-d'));
        $fecha_hasta = $request->get('hasta', now()->format('Y-m-d'));
        $tipo = $request->get('tipo', '');
        
        // Obtener ingresos del período
        $ingresos = Ingreso::whereBetween('created_at', [$fecha_desde, $fecha_hasta . ' 23:59:59'])
            ->get();
            
        // Obtener egresos del período
        $egresos = Egreso::whereBetween('created_at', [$fecha_desde, $fecha_hasta . ' 23:59:59'])
            ->get();
        
        // Debug temporal - eliminar después
        
        // Crear array de flujo de caja
        $cashflow = [];
        
        // Agregar ingresos
        foreach ($ingresos as $ingreso) {
            $cashflow[] = (object) [
                'fecha' => $ingreso->created_at->format('Y-m-d H:i:s'),
                'usuario' => (object) ['name' => 'Sistema'],
                'concepto' => 'Ingreso',
                'detalles' => $ingreso->concepto . ' - ' . ($ingreso->observaciones ?? ''),
                'monto' => (float) $ingreso->monto,
                'tipo_movimiento' => 'entrada'
            ];
        }
        
        // Agregar egresos
        foreach ($egresos as $egreso) {
            $cashflow[] = (object) [
                'fecha' => $egreso->created_at->format('Y-m-d H:i:s'),
                'usuario' => (object) ['name' => 'Sistema'],
                'concepto' => 'Egreso',
                'detalles' => $egreso->concepto . ' - ' . ($egreso->observaciones ?? ''),
                'monto' => (float) $egreso->monto,
                'tipo_movimiento' => 'salida'
            ];
        }
        
        // Ordenar por fecha (optimizado)
        $cashflow = collect($cashflow)->sortBy('fecha')->values()->all();
        
        $fondo_inicial = 0;
        $branch = (object)['name' => 'Matriz'];
        $company = (object)['name' => 'HC Servicios Industrial'];
        
        return view('reportes.cashflow.index', compact(
            'cashflow',
            'fondo_inicial',
            'branch',
            'company',
            'fecha_desde',
            'fecha_hasta'
        ));
    }
}
