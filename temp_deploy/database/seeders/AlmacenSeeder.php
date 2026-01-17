<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Almacen;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Almacen::create([
            'nombre' => 'Almacén 1',
            'direccion' => 'Av. Principal 123',
        ]);
        Almacen::create([
            'nombre' => 'Almacén 2',
            'direccion' => 'Calle Secundaria 456',
        ]);
        Almacen::create([
            'nombre' => 'Almacén 3',
            'direccion' => 'Zona Industrial 789',
        ]);
    }
}
