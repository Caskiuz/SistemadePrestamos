<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Egreso;

class EgresoSeeder extends Seeder
{
    public function run(): void
    {
        Egreso::create([
            'concepto' => 'Pago de proveedor',
            'monto' => 600.00,
            'fecha' => now()->toDateString(),
            'observaciones' => 'Pago realizado a proveedor principal.'
        ]);
        Egreso::create([
            'concepto' => 'Compra de insumos',
            'monto' => 200.00,
            'fecha' => now()->toDateString(),
            'observaciones' => 'Compra de materiales para operación.'
        ]);
    }
}
