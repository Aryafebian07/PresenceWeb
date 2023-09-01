<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\GeneratePertemuanJob;
use App\Jobs\UpdatePertemuanStatusMulai;
use App\Jobs\UpdatePertemuanStatusSelesai;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->job(new GeneratePertemuanJob)->dailyAt('01:43');

        // Jalankan job UpdatePertemuanStatusValidasi setiap menit
    $schedule->job(new UpdatePertemuanStatusMulai)->everyMinute();

    // Jalankan job UpdatePertemuanStatusSelesai setiap menit
    $schedule->job(new UpdatePertemuanStatusSelesai)->everyMinute();
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
