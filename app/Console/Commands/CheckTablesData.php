<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestamo;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\CashFlow;
use Illuminate\Support\Facades\DB;

class CheckTablesData extends Command
{
    protected $signature = 'check:tables';
    protected $description = 'Revisar datos en las tablas principales';

    public function handle()
    {
        $this->info('=== REVISIÓN DE DATOS EN TABLAS ===');
        
        // Clientes
        $clientesCount = Cliente::count();
        $this->info("Clientes: {$clientesCount}");
        if ($clientesCount > 0) {
            $clientes = Cliente::select('id', 'nombre', 'created_at')->limit(3)->get();
            foreach ($clientes as $cliente) {
                $this->line("  - {$cliente->nombre} (ID: {$cliente->id}) - {$cliente->created_at}");
            }
        }
        
        // Préstamos
        $prestamosCount = Prestamo::count();
        $this->info("Préstamos: {$prestamosCount}");
        if ($prestamosCount > 0) {
            $prestamos = Prestamo::select('id', 'folio', 'monto', 'estado', 'created_at')->limit(3)->get();
            foreach ($prestamos as $prestamo) {
                $this->line("  - {$prestamo->folio} - \${$prestamo->monto} - {$prestamo->estado} - {$prestamo->created_at}");
            }
        }
        
        // Cash Flow
        $cashFlowCount = CashFlow::count();
        $this->info("Cash Flow: {$cashFlowCount}");
        if ($cashFlowCount > 0) {
            $cashFlow = CashFlow::select('id', 'concepto', 'monto', 'tipo_movimiento', 'created_at')->limit(3)->get();
            foreach ($cashFlow as $cf) {
                $this->line("  - {$cf->concepto} - \${$cf->monto} - {$cf->tipo_movimiento} - {$cf->created_at}");
            }
        }
        
        // Productos
        $productosCount = Producto::count();
        $this->info("Productos: {$productosCount}");
        if ($productosCount > 0) {
            $productos = Producto::select('id', 'nombre', 'tipo', 'created_at')->limit(3)->get();
            foreach ($productos as $producto) {
                $this->line("  - {$producto->nombre} - {$producto->tipo} - {$producto->created_at}");
            }
        }
        
        $this->info('=== CONSULTAS DE GRÁFICOS ===');
        
        // Préstamos por mes
        $prestamosPorMes = Prestamo::select(
            DB::raw('MONTH(created_at) as mes'),
            DB::raw('COUNT(*) as cantidad'),
            DB::raw('SUM(monto) as monto_total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();
        
        $this->info("Préstamos por mes (año actual): {$prestamosPorMes->count()} registros");
        foreach ($prestamosPorMes as $pm) {
            $this->line("  - Mes {$pm->mes}: {$pm->cantidad} préstamos, \${$pm->monto_total}");
        }
        
        // Estados de préstamos
        $estadosPrestamos = Prestamo::select('estado', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('estado')
            ->get();
            
        $this->info("Estados de préstamos: {$estadosPrestamos->count()} estados");
        foreach ($estadosPrestamos as $ep) {
            $this->line("  - {$ep->estado}: {$ep->cantidad}");
        }
        
        // Flujo de caja
        $flujoCaja = CashFlow::selectRaw('DATE(created_at) as fecha, SUM(CASE WHEN tipo_movimiento = "entrada" THEN monto ELSE -monto END) as flujo')
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('fecha')
        ->get();
        
        $this->info("Flujo de caja (últimos 30 días): {$flujoCaja->count()} registros");
        foreach ($flujoCaja->take(5) as $fc) {
            $this->line("  - {$fc->fecha}: \${$fc->flujo}");
        }
        
        return 0;
    }
}