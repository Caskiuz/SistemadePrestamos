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
        // Log para consola del navegador
        $debugInfo = [
            'step' => 'inicio',
            'email' => $request->input('email'),
            'password_length' => strlen($request->input('password') ?? ''),
            'session_id' => session()->getId(),
            'csrf_token' => $request->session()->token()
        ];
        
        $email = $request->input('email');
        $password = $request->input('password');
        
        if (!$email || !$password) {
            $debugInfo['step'] = 'validation_failed';
            $debugInfo['error'] = 'Email y contraseña requeridos';
            session()->flash('debug_info', $debugInfo);
            return back()->withErrors(['email' => 'Email y contraseña requeridos'])->withInput();
        }
        
        $user = \App\Models\User::where('email', $email)->first();
        $debugInfo['step'] = 'user_search';
        $debugInfo['user_found'] = $user ? true : false;
        
        if (!$user) {
            $debugInfo['error'] = 'Usuario no encontrado';
            session()->flash('debug_info', $debugInfo);
            return back()->withErrors(['email' => 'Usuario no encontrado: ' . $email])->withInput();
        }
        
        $debugInfo['step'] = 'password_check';
        $passwordValid = \Hash::check($password, $user->password);
        $debugInfo['password_valid'] = $passwordValid;
        
        if (!$passwordValid) {
            $debugInfo['error'] = 'Contraseña incorrecta';
            session()->flash('debug_info', $debugInfo);
            return back()->withErrors(['email' => 'Contraseña incorrecta para: ' . $email])->withInput();
        }
        
        $debugInfo['step'] = 'login_attempt';
        \Auth::login($user);
        session()->regenerate();
        session()->save();
        
        $debugInfo['step'] = 'login_success';
        $debugInfo['auth_check'] = \Auth::check();
        $debugInfo['auth_user_id'] = \Auth::id();
        session()->flash('debug_info', $debugInfo);
        
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
