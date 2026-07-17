<?php

// RUTA TEMPORAL PARA CONFIGURAR PRODUCCIÓN
// Eliminar después de usar

use Illuminate\Support\Facades\Route;

Route::get('/setup-produccion', function() {
    $output = "<h2>🚀 CONFIGURACIÓN DE PRODUCCIÓN</h2>";
    
    try {
        // 1. Configurar permisos
        $output .= "<h3>1. Configurando permisos...</h3>";
        
        $storagePath = base_path('storage');
        $cachePath = base_path('bootstrap/cache');
        
        // Intentar configurar permisos recursivamente
        if (is_dir($storagePath)) {
            chmod($storagePath, 0775);
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storagePath));
            foreach ($iterator as $item) {
                chmod($item, 0775);
            }
            $output .= "✅ Permisos de storage/ configurados<br>";
        }
        
        if (is_dir($cachePath)) {
            chmod($cachePath, 0775);
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($cachePath));
            foreach ($iterator as $item) {
                chmod($item, 0775);
            }
            $output .= "✅ Permisos de bootstrap/cache/ configurados<br>";
        }
        
        // 2. Limpiar cache
        $output .= "<h3>2. Limpiando cache...</h3>";
        \Artisan::call('config:clear');
        \Artisan::call('route:clear');
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
        $output .= "✅ Cache limpiado<br>";
        
        // 3. Crear directorios necesarios
        $output .= "<h3>3. Creando directorios...</h3>";
        $dirs = [
            'storage/framework/sessions',
            'storage/framework/cache',
            'storage/framework/views',
            'storage/logs'
        ];
        
        foreach ($dirs as $dir) {
            $fullPath = base_path($dir);
            if (!is_dir($fullPath)) {
                mkdir($fullPath, 0775, true);
                $output .= "✅ Creado: $dir<br>";
            }
        }
        
        // 4. Verificar configuración
        $output .= "<h3>4. Verificación:</h3>";
        $output .= "APP_ENV: " . config('app.env') . "<br>";
        $output .= "APP_URL: " . config('app.url') . "<br>";
        $output .= "SESSION_DRIVER: " . config('session.driver') . "<br>";
        $output .= "SESSION_DOMAIN: " . config('session.domain') . "<br>";
        
        $output .= "<h3>✅ CONFIGURACIÓN COMPLETADA</h3>";
        $output .= "<p><a href='/'>Ir al login</a></p>";
        
    } catch (Exception $e) {
        $output .= "<h3>❌ ERROR:</h3>";
        $output .= "<p>" . $e->getMessage() . "</p>";
    }
    
    return $output;
});