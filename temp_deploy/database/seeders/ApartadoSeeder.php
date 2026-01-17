<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Apartado;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Almacen;

class ApartadoSeeder extends Seeder
{
    public function run(): void
    {
        $cliente = Cliente::first();
        $producto = Producto::first();
        $almacen = Almacen::first();

        if ($cliente && $producto && $almacen) {
            Apartado::create([
                'cliente_id' => $cliente->id,
                'producto_id' => $producto->id,
                'almacen_id' => $almacen->id,
                'anticipo' => 100.00,
                'monto_total' => 1000.00,
                'fecha_apartado' => now()->toDateString(),
                'fecha_vencimiento' => now()->addDays(30)->toDateString(),
                'estado' => 'VIGENTE',
                'observaciones' => 'Apartado de ejemplo generado por el seeder.'
            ]);
        }
    }
}
