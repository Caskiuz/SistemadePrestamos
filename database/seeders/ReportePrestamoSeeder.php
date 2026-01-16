<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReportePrestamo;
use App\Models\Prestamo;

class ReportePrestamoSeeder extends Seeder
{
    public function run(): void
    {
        $prestamo = Prestamo::first();
        if ($prestamo) {
            ReportePrestamo::create([
                'prestamo_id' => $prestamo->id,
                'fecha_reporte' => now()->toDateString(),
                'tipo' => 'PAGO',
                'detalle' => 'Reporte de pago generado por el seeder.'
            ]);
        }
    }
}
