<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        '\App\Console\Commands\BeforeEndProgramCommand',
        '\App\Console\Commands\AfterEndProgramCommand'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('email:before')
        ->everyFiveMinutes()
        ->onFailure(function (\Exception $exception) {
            Log::error('SEND EMAIL BEFORE 3 DAYS SCHEDULING ERROR',[$exception]);
        });

        $schedule->command('email:after')
        ->everyFiveMinutes()
        ->onFailure(function (\Exception $exception) {
            Log::error('SEND EMAIL AFTER END SCHEDULING ERROR',[$exception]);
        });

        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
