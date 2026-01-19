<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class BoliviaLocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Configurar locale para Bolivia
        App::setLocale('es_BO');
        
        // Configurar zona horaria
        Config::set('app.timezone', 'America/La_Paz');
        date_default_timezone_set('America/La_Paz');
        
        // Configurar formato de números para Bolivia
        setlocale(LC_MONETARY, 'es_BO.UTF-8', 'es_BO', 'Spanish_Bolivia');
        setlocale(LC_NUMERIC, 'es_BO.UTF-8', 'es_BO', 'Spanish_Bolivia');
        
        return $next($request);
    }
}