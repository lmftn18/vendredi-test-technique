<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\CreateAdmin::class,
        \App\Console\Commands\UnpublishOldMission::class,
        \App\Console\Commands\CheckLinks::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule( Schedule $schedule )
    {
        $schedule->command( 'vendredi:unpublish-old-missions' )
                 ->daily();
        $schedule->command( 'vendredi:check-links' )
                 ->daily();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path( 'routes/console.php' );
    }
}
