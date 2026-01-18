<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlmacenesSeeder extends Seeder
{
    public function run()
    {
        DB::table('almacenes')->insert([
            [
                'id' => 1,
                'nombre' => 'Santa Ana - Paurito',
                'direccion' => 'Av Paurito frente a la línea 59 roja - Tel: 77340573',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nombre' => 'Santa Ana - Las Américas',
                'direccion' => 'Av Las Américas a lado del mercado paraíso - Tel: 78153778',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nombre' => 'Santa Ana - El Fuerte',
                'direccion' => 'Av El Fuerte diagonal mercado el fuerte - Tel: 71346466',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}