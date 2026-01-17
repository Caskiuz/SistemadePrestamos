<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Garantia;
use App\Models\Prestamo;

class GarantiaSeeder extends Seeder
{
    public function run(): void
    {
        $prestamo = Prestamo::first();
        if ($prestamo) {
            Garantia::create([
                'prestamo_id' => $prestamo->id,
                'descripcion' => 'Garantía estándar de ejemplo',
                'fecha_inicio' => now()->toDateString(),
                'fecha_fin' => now()->addYear()->toDateString(),
                'estado' => 'VIGENTE',
                'observaciones' => 'Garantía generada por el seeder.'
            ]);
        }
    }
}
