<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Create admin user if not exists';

    public function handle()
    {
        $email = 'admin@admin.com';
        $password = '12345678';

        if (User::where('email', $email)->exists()) {
            $this->info('Admin user already exists');
            return;
        }

        User::create([
            'name' => 'Admin',
            'nombre' => 'Admin',
            'email' => $email,
            'password' => Hash::make($password),
            'rol' => 'Gerente',
        ]);

        $this->info('Admin user created successfully');
        $this->info('Email: ' . $email);
        $this->info('Password: ' . $password);
    }
}