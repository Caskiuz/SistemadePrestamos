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
        $tipo_filtro = $request->get('tipo', '');
        
        // Obtener movimientos de cash_flow (préstamos y pagos)
        $query = CashFlow::with('usuario')
            ->whereBetween('fecha', [$fecha_desde, $fecha_hasta . ' 23:59:59']);
            
        // Filtrar por concepto específico
        if ($tipo_filtro) {
            $conceptos = [
                '0' => 'Préstamo',
                '1' => 'Pago de interés extemporáneo',
                '2' => 'Pago de intereses',
                '3' => 'Abono a capital',
                '4' => 'Apartado - Anticipo',
                '5' => 'Venta',
                '6' => 'Compra',
                '7' => 'Cancelación de préstamo',
                '8' => 'Depósito',
                '9' => 'Retiro',
                '13' => 'Egreso'
            ];
            
            if (isset($conceptos[$tipo_filtro])) {
                $query->where('concepto', 'like', '%' . $conceptos[$tipo_filtro] . '%');
            }
        }
        
        $movimientosCashFlow = $query->orderBy('fecha', 'desc')->get();
        
        // Solo incluir ingresos/egresos si no hay filtro específico o si coincide
        $ingresos = [];
        $egresos = [];
        
        if (!$tipo_filtro || $tipo_filtro == '8') { // Depósito
            $ingresos = Ingreso::whereBetween('created_at', [$fecha_desde, $fecha_hasta . ' 23:59:59'])
                ->get();
        }
        
        if (!$tipo_filtro || $tipo_filtro == '13') { // Gasto
            $egresos = Egreso::whereBetween('created_at', [$fecha_desde, $fecha_hasta . ' 23:59:59'])
                ->get();
        }
        
        // Crear array de flujo de caja
        $cashflow = [];
        
        // Agregar movimientos de cash_flow (préstamos y pagos)
        foreach ($movimientosCashFlow as $movimiento) {
            $cashflow[] = (object) [
                'fecha' => $movimiento->fecha->format('Y-m-d H:i:s'),
                'usuario' => $movimiento->usuario ?? (object) ['name' => 'Sistema'],
                'concepto' => $movimiento->concepto,
                'detalles' => $movimiento->detalles,
                'monto' => (float) $movimiento->monto,
                'tipo_movimiento' => $movimiento->tipo_movimiento
            ];
        }
        
        // Agregar ingresos
        foreach ($ingresos as $ingreso) {
            $cashflow[] = (object) [
                'fecha' => $ingreso->created_at->format('Y-m-d H:i:s'),
                'usuario' => (object) ['name' => 'Sistema'],
                'concepto' => 'Depósito',
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
                'concepto' => 'Gasto',
                'detalles' => $egreso->concepto . ' - ' . ($egreso->observaciones ?? ''),
                'monto' => (float) $egreso->monto,
                'tipo_movimiento' => 'salida'
            ];
        }
        
        // Ordenar por fecha (optimizado)
        $cashflow = collect($cashflow)->sortByDesc('fecha')->values()->all();
        
        $fondo_inicial = 0;
        $branch = (object)['name' => 'Matriz'];
        $company = (object)['name' => 'Préstamos Santa Ana'];
        
        return view('reportes.cashflow.index', compact(
            'cashflow',
            'fondo_inicial',
            'branch',
            'company',
            'fecha_desde',
            'fecha_hasta',
            'tipo_filtro'
        ));
    }
}
