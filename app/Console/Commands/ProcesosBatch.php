<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestamo;
use App\Models\CashFlow;
use App\Models\Configuracion;
use App\Services\NotificacionService;
use Carbon\Carbon;

class ProcesosBatch extends Command
{
    protected $signature = 'batch:procesar';
    protected $description = 'Ejecuta procesos batch automáticos del sistema';
    
    private $notificacionService;
    
    public function __construct(NotificacionService $notificacionService)
    {
        parent::__construct();
        $this->notificacionService = $notificacionService;
    }

    public function handle()
    {
        $this->info('Iniciando procesos batch automáticos...');
        
        $this->actualizarEstadosPrestamos();
        $this->calcularInteresesVencidos();
        $this->limpiarNotificacionesAntiguas();
        $this->generarReporteDiario();
        
        $this->info('Procesos batch completados exitosamente.');
    }
    
    private function actualizarEstadosPrestamos()
    {
        $this->info('Actualizando estados de préstamos...');
        
        $hoy = Carbon::now();
        
        // Marcar como vencidos
        $vencidos = Prestamo::where('estado', 'activo')
            ->where('fecha_vencimiento', '<', $hoy)
            ->update(['estado' => 'vencido']);
            
        // Marcar como expirados (30 días después de vencer)
        $expirados = Prestamo::where('estado', 'vencido')
            ->where('fecha_vencimiento', '<', $hoy->copy()->subDays(30))
            ->update(['estado' => 'expirado']);
            
        $this->info("Estados actualizados: {$vencidos} vencidos, {$expirados} expirados");
    }
    
    private function calcularInteresesVencidos()
    {
        $this->info('Calculando intereses de préstamos vencidos...');
        
        $prestamosVencidos = Prestamo::where('estado', 'vencido')
            ->where('fecha_vencimiento', '<', Carbon::now())
            ->get();
            
        $totalIntereses = 0;
        
        foreach ($prestamosVencidos as $prestamo) {
            $diasVencido = Carbon::now()->diffInDays($prestamo->fecha_vencimiento);
            $interesDiario = ($prestamo->monto * ($prestamo->interes_mensual / 100)) / 30;
            $interesVencido = $interesDiario * $diasVencido;
            
            // Actualizar monto pendiente
            $prestamo->update([
                'monto_pendiente' => $prestamo->monto + $interesVencido
            ]);
            
            $totalIntereses += $interesVencido;
        }
        
        $this->info("Intereses calculados: $" . number_format($totalIntereses, 2));
    }
    
    private function limpiarNotificacionesAntiguas()
    {
        $this->info('Limpiando notificaciones antiguas...');
        
        $eliminadas = \App\Models\Notificacion::where('created_at', '<', Carbon::now()->subDays(30))
            ->where('enviada', true)
            ->delete();
            
        $this->info("Notificaciones eliminadas: {$eliminadas}");
    }
    
    private function generarReporteDiario()
    {
        $this->info('Generando reporte diario...');
        
        $hoy = Carbon::today();
        
        $datos = [
            'fecha' => $hoy->format('Y-m-d'),
            'prestamos_nuevos' => Prestamo::whereDate('created_at', $hoy)->count(),
            'pagos_recibidos' => CashFlow::where('tipo', 'ingreso')
                ->whereDate('created_at', $hoy)
                ->sum('monto'),
            'prestamos_activos' => Prestamo::where('estado', 'activo')->count(),
            'prestamos_vencidos' => Prestamo::where('estado', 'vencido')->count(),
            'efectivo_caja' => CashFlow::sum('monto')
        ];
        
        // Guardar en archivo o base de datos
        file_put_contents(
            storage_path('logs/reporte_diario_' . $hoy->format('Y-m-d') . '.json'),
            json_encode($datos, JSON_PRETTY_PRINT)
        );
        
        $this->info('Reporte diario generado: ' . $datos['prestamos_nuevos'] . ' préstamos nuevos');
    }
}