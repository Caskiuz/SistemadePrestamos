<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pago;
use App\Models\Prestamo;

class PagoSeeder extends Seeder
{
    public function run(): void
    {
        $prestamo = Prestamo::first();
        if ($prestamo) {
            Pago::create([
                'prestamo_id' => $prestamo->id,
                'monto' => 500.00,
                'fecha_pago' => now()->toDateString(),
                'metodo' => 'EFECTIVO',
                'observaciones' => 'Primer pago de ejemplo.'
            ]);
        }
    }
}
