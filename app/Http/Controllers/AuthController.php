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
        try {
            $user = \App\Models\User::where('email', $request->email)->first();
            if (!$user) {
                return back()->withErrors(['email' => 'Usuario no encontrado'])->withInput();
            }
            if (!\Hash::check($request->password, $user->password)) {
                return back()->withErrors(['email' => 'Contraseña incorrecta'])->withInput();
            }

            \Auth::login($user);
            session()->regenerate();
            session()->save();
            
            // REDIRECT DIRECTO SIN ROUTE
            return redirect('/home');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Error: ' . $e->getMessage()])->withInput();
        }
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
