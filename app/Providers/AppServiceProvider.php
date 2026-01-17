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
        
        // Force HTTPS in production
        if (env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }
        
// ELIMINAR AUTO-MIGRACION QUE CAUSA PROBLEMAS
        // Auto-migrate in production
        // if (env('APP_ENV') === 'production' && !app()->runningInConsole()) {
        //     try {
        //         if (!Schema::hasTable('migrations')) {
        //             Artisan::call('migrate:install');
        //         }
        //         Artisan::call('migrate', ['--force' => true]);
        //         
        //         // Run seeders only if users table is empty
        //         if (Schema::hasTable('users') && \DB::table('users')->count() === 0) {
        //             Artisan::call('db:seed', ['--force' => true]);
        //         }
        //     } catch (\Exception $e) {
        //         \Log::error('Auto-migration failed: ' . $e->getMessage());
        //     }
        // }
    }
}
