<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sucursal;

class SucursalSeeder extends Seeder
{
    public function run(): void
    {
        Sucursal::create(['nombre' => 'Almacén Central', 'direccion' => 'Av. Principal 123', 'telefono' => '70000001', 'ciudad' => 'Ciudad 1']);
        Sucursal::create(['nombre' => 'Almacén Norte', 'direccion' => 'Calle Norte 456', 'telefono' => '70000002', 'ciudad' => 'Ciudad 2']);
        Sucursal::create(['nombre' => 'Almacén Sur', 'direccion' => 'Av. Sur 789', 'telefono' => '70000003', 'ciudad' => 'Ciudad 3']);
    }
}
