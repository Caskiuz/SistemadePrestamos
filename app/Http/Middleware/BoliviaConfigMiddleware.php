<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;

class BoliviaConfigMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Configurar timezone
        Config::set('app.timezone', config('bolivia-global.timezone'));
        
        // Configurar locale
        app()->setLocale('es');
        
        // Compartir configuración con todas las vistas
        View::share('boliviaConfig', config('bolivia-global'));
        
        // Agregar variables globales para las vistas
        View::composer('*', function ($view) {
            $view->with([
                'currencySymbol' => config('bolivia-global.currency_symbol'),
                'countryName' => config('bolivia-global.country'),
                'dateFormat' => config('bolivia-global.date_format'),
            ]);
        });
        
        return $next($request);
    }
}