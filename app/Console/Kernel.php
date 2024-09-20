<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('custom:TestCommand')->everyMinute();
        // $schedule->command('users:create')->everyMinute();
        // $schedule->command('users:delete')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected $commands = [
        \App\Console\Commands\TestCommand::class,
        \App\Console\Commands\CreateUser::class,
        \App\Console\Commands\UsersDelete::class,
    ];
}
