<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\CashFlow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardAvanzadoController extends Controller
{
    public function index()
    {
        $kpis = $this->getKPIs();
        $graficos = $this->getGraficos();
        
        return view('modules.dashboard.avanzado', compact('kpis', 'graficos'));
    }
    
    private function getKPIs()
    {
        $hoy = Carbon::today();
        $mesActual = Carbon::now()->startOfMonth();
        
        return [
            'prestamos_activos' => Prestamo::where('estado', 'activo')->count(),
            'monto_prestado_mes' => Prestamo::where('created_at', '>=', $mesActual)->sum('monto') ?? 0,
            'clientes_activos' => Cliente::whereHas('prestamos', function($q) {
                $q->where('estado', 'activo');
            })->count(),
            'efectivo_caja' => CashFlow::selectRaw('SUM(CASE WHEN tipo_movimiento = "entrada" THEN monto ELSE -monto END) as total')->value('total') ?? 0,
            'prestamos_vencidos' => Prestamo::where('estado', 'vencido')->count(),
            'tasa_recuperacion' => $this->calcularTasaRecuperacion(),
            'rentabilidad_mes' => $this->calcularRentabilidadMes(),
            'productos_inventario' => Producto::where('estado', 'disponible')->count()
        ];
    }
    
    private function getGraficos()
    {
        return [
            'prestamos_por_mes' => $this->prestamosPorMes(),
            'estados_prestamos' => $this->estadosPrestamos(),
            'flujo_caja_semanal' => $this->flujoCajaSemanal(),
            'top_clientes' => $this->topClientes(),
            'tipos_productos' => $this->tiposProductos()
        ];
    }
    
    private function prestamosPorMes()
    {
        return Prestamo::select(
            DB::raw('MONTH(created_at) as mes'),
            DB::raw('COUNT(*) as cantidad'),
            DB::raw('SUM(monto) as monto_total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();
    }
    
    private function estadosPrestamos()
    {
        return Prestamo::select('estado', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('estado')
            ->get();
    }
    
    private function flujoCajaSemanal()
    {
        // Obtener datos reales de cash_flow
        $cashFlowData = CashFlow::select(
            DB::raw('WEEK(created_at) as semana'),
            DB::raw('SUM(CASE WHEN tipo_movimiento = "entrada" THEN monto ELSE -monto END) as flujo')
        )
        ->where('created_at', '>=', Carbon::now()->subWeeks(8))
        ->groupBy('semana')
        ->orderBy('semana')
        ->get();
        
        // Si no hay datos, crear datos de ejemplo
        if ($cashFlowData->isEmpty()) {
            $semanas = [];
            for ($i = 7; $i >= 0; $i--) {
                $semanas[] = (object) [
                    'semana' => Carbon::now()->subWeeks($i)->week,
                    'flujo' => rand(-5000, 15000)
                ];
            }
            return collect($semanas);
        }
        
        return $cashFlowData;
    }
    
    private function topClientes()
    {
        return Cliente::select('clientes.*', DB::raw('COUNT(prestamos.id) as total_prestamos'))
            ->leftJoin('prestamos', 'clientes.id', '=', 'prestamos.cliente_id')
            ->groupBy('clientes.id')
            ->orderBy('total_prestamos', 'desc')
            ->limit(10)
            ->get();
    }
    
    private function tiposProductos()
    {
        $productos = Producto::select('tipo', DB::raw('COUNT(*) as cantidad'))
            ->whereNotNull('tipo')
            ->groupBy('tipo')
            ->get();
            
        // Si no hay productos, crear datos de ejemplo
        if ($productos->isEmpty()) {
            return collect([
                (object) ['tipo' => 'Joyería', 'cantidad' => 25],
                (object) ['tipo' => 'Electrónicos', 'cantidad' => 15],
                (object) ['tipo' => 'Herramientas', 'cantidad' => 10],
                (object) ['tipo' => 'Otros', 'cantidad' => 8]
            ]);
        }
        
        return $productos;
    }
    
    private function calcularTasaRecuperacion()
    {
        $totalPrestamos = Prestamo::count();
        $prestamosLiquidados = Prestamo::where('estado', 'liquidado')->count();
        
        return $totalPrestamos > 0 ? round(($prestamosLiquidados / $totalPrestamos) * 100, 2) : 0;
    }
    
    private function calcularRentabilidadMes()
    {
        $mesActual = Carbon::now()->startOfMonth();
        
        // Calcular ingresos desde cash_flow
        $ingresos = CashFlow::where('tipo_movimiento', 'entrada')
            ->where('created_at', '>=', $mesActual)
            ->sum('monto') ?? 0;
            
        // Calcular egresos desde cash_flow
        $egresos = CashFlow::where('tipo_movimiento', 'salida')
            ->where('created_at', '>=', $mesActual)
            ->sum('monto') ?? 0;
            
        return $ingresos - $egresos;
    }
    
    public function getDataAjax(Request $request)
    {
        $tipo = $request->get('tipo');
        
        switch($tipo) {
            case 'kpis':
                return response()->json($this->getKPIs());
            case 'prestamos_mes':
                return response()->json($this->prestamosPorMes());
            case 'estados':
                return response()->json($this->estadosPrestamos());
            default:
                return response()->json(['error' => 'Tipo no válido']);
        }
    }
}