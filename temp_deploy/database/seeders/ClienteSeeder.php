<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        Cliente::create([
            'tipo' => 'PERSONA',
            'nombre' => 'Juan Pérez',
            'tipo_documento' => 'CI',
            'numero_documento' => 'CI123456',
            'telefono_1' => '70000001',
            'telefono_2' => null,
            'telefono_3' => null,
            'email' => 'juan.perez@email.com',
            'ciudad' => 'Ciudad 1',
            'direccion' => 'Av. Siempre Viva 123',
        ]);
        Cliente::create([
            'tipo' => 'PERSONA',
            'nombre' => 'Ana García',
            'tipo_documento' => 'CI',
            'numero_documento' => 'CI654321',
            'telefono_1' => '70000002',
            'telefono_2' => null,
            'telefono_3' => null,
            'email' => 'ana.garcia@email.com',
            'ciudad' => 'Ciudad 2',
            'direccion' => 'Calle Falsa 456',
        ]);
        Cliente::create([
            'tipo' => 'PERSONA',
            'nombre' => 'Luis Martínez',
            'tipo_documento' => 'CI',
            'numero_documento' => 'CI789123',
            'telefono_1' => '70000003',
            'telefono_2' => null,
            'telefono_3' => null,
            'email' => 'luis.martinez@email.com',
            'ciudad' => 'Ciudad 3',
            'direccion' => 'Zona Sur 789',
        ]);
    }
}
