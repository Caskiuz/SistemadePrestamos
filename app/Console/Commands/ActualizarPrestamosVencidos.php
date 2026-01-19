<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestamo;
use Carbon\Carbon;

class ActualizarPrestamosVencidos extends Command
{
    protected $signature = 'prestamos:actualizar-estados';
    protected $description = 'Actualiza automáticamente los estados de préstamos (vencidos y expirados)';

    public function handle()
    {
        $hoy = Carbon::now();
        
        // Actualizar préstamos activos a vencidos
        $prestamosVencidos = Prestamo::where('estado', 'activo')
            ->whereDate('fecha_vencimiento', '<', $hoy)
            ->get();

        $countVencidos = 0;
        foreach ($prestamosVencidos as $prestamo) {
            $prestamo->update(['estado' => 'vencido']);
            $countVencidos++;
        }

        // Actualizar préstamos vencidos a expirados (después de 30 días de vencimiento)
        $fechaExpiracion = $hoy->copy()->subDays(30);
        $prestamosExpirados = Prestamo::where('estado', 'vencido')
            ->whereDate('fecha_vencimiento', '<', $fechaExpiracion)
            ->get();

        $countExpirados = 0;
        foreach ($prestamosExpirados as $prestamo) {
            $prestamo->update(['estado' => 'expirado']);
            
            // Cuando expira, las prendas pasan a estar disponibles para venta
            foreach ($prestamo->productos as $producto) {
                $producto->update(['estado' => 'en_venta']);
            }
            $countExpirados++;
        }

        $this->info("Se actualizaron {$countVencidos} préstamos a estado 'vencido'");
        $this->info("Se actualizaron {$countExpirados} préstamos a estado 'expirado'");
        return 0;
    }
}