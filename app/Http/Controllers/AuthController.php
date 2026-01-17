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
        $email = $request->input('email');
        $password = $request->input('password');
        
        if (!$email || !$password) {
            return back()->withErrors(['email' => 'Email y contraseña requeridos'])->withInput();
        }
        
        $user = \App\Models\User::where('email', $email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Usuario no encontrado: ' . $email])->withInput();
        }
        
        if (!\Hash::check($password, $user->password)) {
            return back()->withErrors(['email' => 'Contraseña incorrecta para: ' . $email])->withInput();
        }
        
        // CONFIGURACIÓN ESPECIAL PARA RENDER
        \Auth::login($user, true); // remember = true
        
        // Configurar sesión manualmente
        $request->session()->regenerate();
        $request->session()->put('auth.user_id', $user->id);
        $request->session()->put('auth.logged_in', true);
        $request->session()->save();
        
        // Forzar cookies de sesión
        cookie()->queue('laravel_session', $request->session()->getId(), 120, '/', '.onrender.com', true, true);
        
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
