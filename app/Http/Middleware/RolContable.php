<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolContable
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->rol, ['Gerente', 'Contabilidad'])) {
            abort(403, 'No tienes permiso para acceder a esta sección. Solo los usuarios con rol de Gerente o Contabilidad pueden acceder.');
        }
        return $next($request);
    }
}
