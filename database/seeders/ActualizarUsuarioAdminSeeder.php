<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class ActualizarUsuarioAdminSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('email', 'admin@admin.com')->first();
        
        if ($admin) {
            $admin->update([
                'nombre' => 'Administrador',
                'name' => 'Administrador'
            ]);
            
            $this->command->info('Usuario admin actualizado correctamente.');
        } else {
            $this->command->error('Usuario admin no encontrado.');
        }
    }
}