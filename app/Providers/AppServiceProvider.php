<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('path.public', function() {
            return base_path('public_html');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app->bind('path.public', function() {
            return base_path('public_html');
        });
        
        // Cargar helpers de Bolivia
        require_once app_path('Helpers/BoliviaConfig.php');
        require_once app_path('Helpers/BoliviaHelper.php');
        require_once app_path('Helpers/CurrencyHelper.php');
        
        // CONFIGURACIÓN HTTPS PARA RENDER Y TÚNELES
        if (env('APP_ENV') === 'production' || request()->isSecure() || request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
