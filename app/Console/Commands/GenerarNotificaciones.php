<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestamo;
use App\Models\Notificacion;
use Carbon\Carbon;

class GenerarNotificaciones extends Command
{
    protected $signature = 'notificaciones:generar';
    protected $description = 'Genera notificaciones automáticas para préstamos';

    public function handle()
    {
        $hoy = Carbon::now();
        
        // Préstamos que vencen en 3 días
        $proximosVencer = Prestamo::where('estado', 'activo')
            ->whereBetween('fecha_vencimiento', [$hoy->copy()->addDays(2), $hoy->copy()->addDays(3)])
            ->get();

        foreach ($proximosVencer as $prestamo) {
            Notificacion::firstOrCreate([
                'tipo' => 'vencimiento',
                'prestamo_id' => $prestamo->id,
                'cliente_id' => $prestamo->cliente_id,
            ], [
                'titulo' => 'Préstamo próximo a vencer',
                'mensaje' => "Su préstamo {$prestamo->folio} vence el {$prestamo->fecha_vencimiento->format('d/m/Y')}",
                'canal' => 'sistema'
            ]);
        }

        // Préstamos vencidos
        $vencidos = Prestamo::where('estado', 'activo')
            ->where('fecha_vencimiento', '<', $hoy)
            ->get();

        foreach ($vencidos as $prestamo) {
            Notificacion::firstOrCreate([
                'tipo' => 'vencido',
                'prestamo_id' => $prestamo->id,
                'cliente_id' => $prestamo->cliente_id,
            ], [
                'titulo' => 'Préstamo vencido',
                'mensaje' => "Su préstamo {$prestamo->folio} venció el {$prestamo->fecha_vencimiento->format('d/m/Y')}",
                'canal' => 'sistema'
            ]);
        }

        $this->info('Notificaciones generadas correctamente');
    }
}