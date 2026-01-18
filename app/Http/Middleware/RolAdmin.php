<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->rol !== 'Gerente') {
            abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
        }

        return $next($request);
    }
}