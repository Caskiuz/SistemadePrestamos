<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Backup;
use Illuminate\Support\Facades\Storage;

class GenerarBackup extends Command
{
    protected $signature = 'backup:generar {--tipo=automatico}';
    protected $description = 'Genera backup de la base de datos';

    public function handle()
    {
        $tipo = $this->option('tipo');
        $fecha = now()->format('Y-m-d_H-i-s');
        $nombreArchivo = "backup_{$fecha}.sql";
        $rutaCompleta = storage_path("app/backups/{$nombreArchivo}");

        // Crear directorio si no existe
        if (!file_exists(dirname($rutaCompleta))) {
            mkdir(dirname($rutaCompleta), 0755, true);
        }

        $backup = Backup::create([
            'nombre' => $nombreArchivo,
            'ruta' => $rutaCompleta,
            'tamaño' => 0,
            'tipo' => $tipo,
            'estado' => 'en_proceso',
            'fecha_backup' => now(),
            'usuario_id' => auth()->id()
        ]);

        try {
            $host = config('database.connections.mysql.host');
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');

            $comando = "mysqldump -h{$host} -u{$username} -p{$password} {$database} > {$rutaCompleta}";
            exec($comando, $output, $returnCode);

            if ($returnCode === 0 && file_exists($rutaCompleta)) {
                $tamaño = filesize($rutaCompleta);
                $backup->update([
                    'tamaño' => $tamaño,
                    'estado' => 'completado'
                ]);
                
                $this->info("Backup generado exitosamente: {$nombreArchivo}");
            } else {
                $backup->update(['estado' => 'fallido']);
                $this->error('Error al generar backup');
            }
        } catch (\Exception $e) {
            $backup->update(['estado' => 'fallido']);
            $this->error('Error: ' . $e->getMessage());
        }
    }
}