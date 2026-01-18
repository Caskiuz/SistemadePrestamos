<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestamo;
use Carbon\Carbon;

class ActualizarPrestamosVencidos extends Command
{
    protected $signature = 'prestamos:actualizar-vencidos';
    protected $description = 'Actualiza el estado de préstamos activos que han vencido';

    public function handle()
    {
        $prestamosVencidos = Prestamo::where('estado', 'activo')
            ->whereDate('fecha_vencimiento', '<', Carbon::now())
            ->get();

        $count = 0;
        foreach ($prestamosVencidos as $prestamo) {
            $prestamo->update(['estado' => 'vencido']);
            $count++;
        }

        $this->info("Se actualizaron {$count} préstamos a estado 'vencido'");
        return 0;
    }
}