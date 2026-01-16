<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingreso;

class IngresoSeeder extends Seeder
{
    public function run(): void
    {
        Ingreso::create([
            'concepto' => 'Pago de cliente',
            'monto' => 1500.00,
            'fecha' => now()->toDateString(),
            'observaciones' => 'Ingreso de ejemplo generado por el seeder.'
        ]);
        Ingreso::create([
            'concepto' => 'Venta de producto',
            'monto' => 800.00,
            'fecha' => now()->toDateString(),
            'observaciones' => 'Ingreso por venta.'
        ]);
    }
}
