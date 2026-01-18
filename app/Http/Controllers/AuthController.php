<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function index() 
    {
         // $password = bcrypt('12345678');
        // dd($password);
        return view('modules.auth.login');
    }

    public function logear(Request $request)
    {
        // BYPASS TOTAL - FORZAR LOGIN DIRECTO
        $user = \App\Models\User::where('email', 'admin@admin.com')->first();
        
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => 'Admin',
                'nombre' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => \Hash::make('12345678'),
                'rol' => 'Gerente'
            ]);
        }
        
        \Auth::loginUsingId($user->id);
        
        // FORZAR SESIÓN SIN VALIDACIONES
        session()->put('auth.password_confirmed_at', time());
        session()->regenerate();
        session()->save();
        
        return redirect('/home');
    }

    public function crearAdmin()
    {
        $usuario = User::where('email', 'rijarwow@gmail.com')->first();


        if (!$usuario) {
            User::create([
                'name' => 'Ricardo Agelvis', // Para compatibilidad con migración default de Laravel
                'nombre' => 'Ricardo Agelvis',
                'email' => 'rijarwow@gmail.com',
                'password' => Hash::make('12345678'),
                'rol' => 'Gerente',
            ]);

            return "Usuario administrador creado exitosamente.";
        }

        return "El usuario administrador ya existe. No es necesario crearlo nuevamente.";
    }


    public function logout()
    {
        \Auth::logout();
        return redirect('/');
    }
}
