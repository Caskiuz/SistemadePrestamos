<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\GenerarNotificaciones::class,
        Commands\GenerarBackup::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Generar notificaciones diariamente a las 8:00 AM
        $schedule->command('notificaciones:generar')
                 ->dailyAt('08:00');

        // Backup automático diario a las 2:00 AM
        $schedule->command('backup:generar --tipo=automatico')
                 ->dailyAt('02:00');

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