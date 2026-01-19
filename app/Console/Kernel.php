<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\GenerarNotificaciones::class,
        Commands\GenerarBackup::class,
        Commands\ProcesosBatch::class,
        Commands\ActualizarPrestamosVencidos::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Notificaciones cada hora en horario laboral
        $schedule->command('notificaciones:generar')
                 ->hourly()
                 ->between('8:00', '18:00');
                 
        // Procesos batch diarios a las 6:00 AM
        $schedule->command('batch:procesar')
                 ->dailyAt('06:00');

        // Backup automático diario a las 2:00 AM
        $schedule->command('backup:generar --tipo=automatico')
                 ->dailyAt('02:00');

        // Actualizar préstamos vencidos cada 4 horas
        $schedule->command('prestamos:actualizar-vencidos')
                 ->cron('0 */4 * * *');

        // Limpiar logs antiguos semanalmente
        $schedule->command('log:clear')
                 ->weekly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}