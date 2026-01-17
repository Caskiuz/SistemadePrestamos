<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class DeployController extends Controller
{
    public function migrate(Request $request)
    {
        // Solo permitir en producción y con token secreto
        if (env('APP_ENV') !== 'production' || $request->get('token') !== env('DEPLOY_TOKEN', 'secret123')) {
            abort(403, 'Unauthorized');
        }

        try {
            $output = [];
            
            // Instalar tabla de migraciones si no existe
            if (!Schema::hasTable('migrations')) {
                Artisan::call('migrate:install');
                $output[] = 'Migration table created';
            }
            
            // Ejecutar migraciones
            Artisan::call('migrate', ['--force' => true]);
            $output[] = 'Migrations executed: ' . Artisan::output();
            
            // Ejecutar seeders si la tabla users está vacía
            if (Schema::hasTable('users') && \DB::table('users')->count() === 0) {
                Artisan::call('db:seed', ['--force' => true]);
                $output[] = 'Seeders executed: ' . Artisan::output();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Deployment completed successfully',
                'output' => $output
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Deployment failed: ' . $e->getMessage()
            ], 500);
        }
    }
}