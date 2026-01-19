<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prestamo;
use Carbon\Carbon;

class ActualizarEstadosPrestamosSeeder extends Seeder
{
    public function run()
    {
        $hoy = Carbon::now();
        
        // Actualizar préstamos que tenían estado 'por_vencer' a 'activo'
        Prestamo::where('estado', 'por_vencer')->update(['estado' => 'activo']);
        
        // Actualizar préstamos activos que ya vencieron
        Prestamo::where('estado', 'activo')
            ->whereDate('fecha_vencimiento', '<', $hoy)
            ->update(['estado' => 'vencido']);
        
        // Actualizar préstamos vencidos que ya expiraron (más de 30 días vencidos)
        $fechaExpiracion = $hoy->copy()->subDays(30);
        Prestamo::where('estado', 'vencido')
            ->whereDate('fecha_vencimiento', '<', $fechaExpiracion)
            ->update(['estado' => 'expirado']);
        
        $this->command->info('Estados de préstamos actualizados correctamente.');
    }
}