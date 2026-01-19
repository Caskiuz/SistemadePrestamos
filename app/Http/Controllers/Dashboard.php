<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\CashFlow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function index()
    {
        $kpis = $this->getKPIs();
        $graficos = $this->getGraficos();
        
        return view('modules.dashboard.home', compact('kpis', 'graficos'));
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
            'productos_inventario' => Producto::where('estado', 'disponible')->count(),
            'total_clientes' => Cliente::count(),
            'prestamos_por_vencer' => Prestamo::where('estado', 'activo')
                ->where('fecha_vencimiento', '<=', Carbon::now()->addDays(3))
                ->count()
        ];
    }
    
    private function getGraficos()
    {
        return [
            'prestamos_por_mes' => $this->prestamosPorMes(),
            'estados_prestamos' => $this->estadosPrestamos(),
            'flujo_caja_semanal' => $this->flujoCajaSemanal(),
            'top_clientes' => $this->topClientes(),
            'tipos_productos' => $this->tiposProductos(),
            'prestamos_recientes' => $this->prestamosRecientes()
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
        return CashFlow::selectRaw('DATE(created_at) as fecha, SUM(CASE WHEN tipo_movimiento = "entrada" THEN monto ELSE -monto END) as flujo')
        ->where('created_at', '>=', Carbon::now()->subDays(30))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('fecha')
        ->get();
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
        return Producto::select('tipo', DB::raw('COUNT(*) as cantidad'))
            ->whereNotNull('tipo')
            ->groupBy('tipo')
            ->get();
    }
    
    private function prestamosRecientes()
    {
        return Prestamo::with('cliente')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
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
        
        $ingresos = CashFlow::where('tipo_movimiento', 'entrada')
            ->where('created_at', '>=', $mesActual)
            ->sum('monto') ?? 0;
            
        $egresos = CashFlow::where('tipo_movimiento', 'salida')
            ->where('created_at', '>=', $mesActual)
            ->sum('monto') ?? 0;
            
        return $ingresos - $egresos;
    }
}
