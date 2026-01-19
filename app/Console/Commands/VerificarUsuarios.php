<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class VerificarUsuarios extends Command
{
    protected $signature = 'usuarios:verificar';
    protected $description = 'Verifica los usuarios en la base de datos';

    public function handle()
    {
        $this->info('Usuarios en la base de datos:');
        $this->info('================================');

        $usuarios = User::all(['id', 'name', 'nombre', 'email', 'rol']);

        foreach ($usuarios as $usuario) {
            $this->info("ID: {$usuario->id}");
            $this->info("Name: {$usuario->name}");
            $this->info("Nombre: {$usuario->nombre}");
            $this->info("Email: {$usuario->email}");
            $this->info("Rol: {$usuario->rol}");
            $this->info("--------------------------------");
        }

        return 0;
    }
}