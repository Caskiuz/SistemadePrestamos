<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado;
use Illuminate\Support\Facades\Hash;

class EmpleadoSeeder extends Seeder
{
    public function run(): void
    {
        Empleado::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan.perez@empresa.com',
            'telefono' => '70000001',
            'direccion' => 'Av. Principal 123',
            'rol' => 'ADMINISTRADOR',
            'password' => Hash::make('admin123'),
            'activo' => true,
            'fecha_ingreso' => now()->subYears(2)->toDateString(),
            'fecha_salida' => null,
        ]);
        Empleado::create([
            'nombre' => 'Ana',
            'apellido' => 'García',
            'email' => 'ana.garcia@empresa.com',
            'telefono' => '70000002',
            'direccion' => 'Calle Secundaria 456',
            'rol' => 'EMPLEADO',
            'password' => Hash::make('empleado123'),
            'activo' => true,
            'fecha_ingreso' => now()->subYear()->toDateString(),
            'fecha_salida' => null,
        ]);
    }
}
