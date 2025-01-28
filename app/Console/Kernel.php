<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendInspirationalMessage;
use App\Http\Controllers\AttendanceController;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Existing comment, but now we'll add our scheduling logic here
        // $schedule->command('inspire')->hourly();

        $schedule->job(new SendInspirationalMessage)->dailyAt('08:00');
        $schedule->call([AttendanceController::class, 'checkAttendance'])->weeklyOn(7, '10:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
