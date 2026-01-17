<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'rol.contable' => \App\Http\Middleware\RolContable::class,
        ]);
        // Configurar sesiones para que funcionen correctamente
        $middleware->web(append: [
            \Illuminate\Session\Middleware\StartSession::class,
        ]);
        // Desactivar CSRF temporalmente para solucionar error 419
        $middleware->validateCsrfTokens(except: [
            '/logear',
            '/login-bypass'
        ]);
        // Puedes agregar más middlewares personalizados aquí si lo necesitas
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();