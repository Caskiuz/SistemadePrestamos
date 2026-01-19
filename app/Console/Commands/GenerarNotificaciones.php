<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestamo;
use App\Models\Configuracion;
use App\Services\NotificacionService;
use Carbon\Carbon;

class GenerarNotificaciones extends Command
{
    protected $signature = 'notificaciones:generar';
    protected $description = 'Genera y envía notificaciones automáticas para préstamos';
    
    private $notificacionService;
    
    public function __construct(NotificacionService $notificacionService)
    {
        parent::__construct();
        $this->notificacionService = $notificacionService;
    }

    public function handle()
    {
        $configuracion = Configuracion::pluck('valor', 'clave')->toArray();
        
        if (!($configuracion['notif_automaticas'] ?? true)) {
            $this->info('Notificaciones automáticas desactivadas');
            return;
        }
        
        $diasVencimiento = $configuracion['notif_dias_vencimiento'] ?? 3;
        $hoy = Carbon::now();
        
        // Préstamos próximos a vencer
        $proximosVencer = Prestamo::where('estado', 'activo')
            ->whereBetween('fecha_vencimiento', [
                $hoy->copy()->addDays($diasVencimiento - 1), 
                $hoy->copy()->addDays($diasVencimiento)
            ])
            ->with('cliente')
            ->get();

        foreach ($proximosVencer as $prestamo) {
            $this->notificacionService->enviarNotificacion('vencimiento_proximo', $prestamo);
            $this->info("Notificación de vencimiento enviada para préstamo {$prestamo->folio}");
        }

        // Préstamos vencidos (1 día después)
        $vencidos = Prestamo::where('estado', 'activo')
            ->whereBetween('fecha_vencimiento', [
                $hoy->copy()->subDay(),
                $hoy
            ])
            ->with('cliente')
            ->get();

        foreach ($vencidos as $prestamo) {
            // Cambiar estado a vencido
            $prestamo->update(['estado' => 'vencido']);
            
            $this->notificacionService->enviarNotificacion('vencido', $prestamo);
            $this->info("Notificación de vencimiento enviada para préstamo {$prestamo->folio}");
        }
        
        // Préstamos muy vencidos (7 días después)
        $muyVencidos = Prestamo::where('estado', 'vencido')
            ->where('fecha_vencimiento', '<', $hoy->copy()->subDays(7))
            ->with('cliente')
            ->get();
            
        foreach ($muyVencidos as $prestamo) {
            $this->notificacionService->enviarNotificacion('muy_vencido', $prestamo, 'sms');
            $this->info("SMS de cobranza enviado para préstamo {$prestamo->folio}");
        }

        $total = $proximosVencer->count() + $vencidos->count() + $muyVencidos->count();
        $this->info("Proceso completado. {$total} notificaciones procesadas.");
    }
}