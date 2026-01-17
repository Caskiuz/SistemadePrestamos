<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Interes;

class InteresSeeder extends Seeder
{
    public function run(): void
    {
        Interes::create([
            'nombre' => 'General',
            'porcentaje' => 10.00,
            'descripcion' => 'Interés general para préstamos.',
            'activo' => true,
        ]);
    }
}
