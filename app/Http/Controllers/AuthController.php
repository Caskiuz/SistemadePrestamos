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
        \Log::info('Login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'session_id' => $request->session()->getId(),
            'csrf_token' => $request->session()->token()
        ]);

        try {
            $credenciales = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();
            if (!$user) {
                \Log::warning('Login failed: User not found', ['email' => $request->email]);
                return back()->withErrors(['email' => 'Correo invalido.'])->withInput();
            }
            if (!Hash::check($request->password, (string) $user->password)) {
                \Log::warning('Login failed: Wrong password', ['email' => $request->email]);
                return back()->withErrors(['email' => 'Contraseña incorrecta.'])->withInput();
            }
            if (!$user->activo) {
                \Log::warning('Login failed: Inactive user', ['email' => $request->email]);
                return back()->withErrors(['email' => 'Usuario inactivo.'])->withInput();
            }

            Auth::login($user);
            $request->session()->regenerate();
            
            \Log::info('Login successful', ['user_id' => $user->id, 'email' => $user->email]);

            return to_route('dashboard.index');
        } catch (\Exception $e) {
            \Log::error('Login error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['email' => 'Error en el sistema: ' . $e->getMessage()])->withInput();
        }
    }

    public function crearAdmin()
    {
        $usuario = User::where('email', 'admin@gmail.com')->first();


        if (!$usuario) {
            User::create([
                'name' => 'Administrador', // Para compatibilidad con migración default de Laravel
                'nombre' => 'Administrador',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'rol' => 'Gerente',
            ]);

            return "Usuario administrador creado exitosamente.";
        }

        return "El usuario administrador ya existe. No es necesario crearlo nuevamente.";
    }


    public function logout()
    {
        Auth::logout();
        

        return to_route('login');
    }
}
