<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ReemplazarSimbolosDolar extends Command
{
    protected $signature = 'bolivia:reemplazar-dolares';
    protected $description = 'Reemplaza todos los símbolos $ con formatCurrency() en las vistas';

    public function handle()
    {
        $this->info('Buscando y reemplazando símbolos $ en las vistas...');

        $viewsPath = resource_path('views');
        $files = File::allFiles($viewsPath);
        $replacements = 0;

        foreach ($files as $file) {
            if ($file->getExtension() === 'php') {
                $content = File::get($file->getPathname());
                $originalContent = $content;

                // Patrones a reemplazar
                $patterns = [
                    // ${{ number_format($variable, 2) }}
                    '/\$\{\{\s*number_format\(\$([^,]+),\s*2\)\s*\}\}/' => '{{ formatCurrency($\1) }}',
                    
                    // ${{ number_format($variable, 2, ',', '.') }}
                    '/\$\{\{\s*number_format\(\$([^,]+),\s*2,\s*[\'"][,][\'"],\s*[\'"][.][\'"]?\)\s*\}\}/' => '{{ formatCurrency($\1) }}',
                    
                    // Casos específicos como $0.00
                    '/\$0\.00/' => '{{ formatCurrency(0) }}',
                    
                    // ${{ $variable }}
                    '/\$\{\{\s*\$([^}]+)\s*\}\}/' => '{{ formatCurrency($\1) }}',
                ];

                foreach ($patterns as $pattern => $replacement) {
                    $newContent = preg_replace($pattern, $replacement, $content);
                    if ($newContent !== $content) {
                        $content = $newContent;
                        $replacements++;
                    }
                }

                // Solo escribir si hubo cambios
                if ($content !== $originalContent) {
                    File::put($file->getPathname(), $content);
                    $this->info("✅ Actualizado: " . $file->getRelativePathname());
                }
            }
        }

        $this->info("🎉 Proceso completado. Se realizaron {$replacements} reemplazos.");
        return 0;
    }
}