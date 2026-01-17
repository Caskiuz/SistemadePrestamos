<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Devolucion;
use App\Models\Prestamo;

class DevolucionSeeder extends Seeder
{
    public function run(): void
    {
        $prestamo = Prestamo::first();
        if ($prestamo) {
            Devolucion::create([
                'prestamo_id' => $prestamo->id,
                'fecha_devolucion' => now()->toDateString(),
                'estado' => 'COMPLETA',
                'observaciones' => 'Devolución de ejemplo.'
            ]);
        }
    }
}
