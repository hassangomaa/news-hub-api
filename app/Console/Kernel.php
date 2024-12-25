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
        // $schedule->command('inspire')->hourly();
        // Schedule for New York Times API
        $schedule->command('nytimes:fetch --query=technology --begin-date=20240101 --end-date=20241231')
            ->everyFourHours()
            ->withoutOverlapping()
            ->before(function () {
                \Log::info('NYTimes fetch job starting.');
            })
            ->after(function () {
                \Log::info('NYTimes fetch job completed.');
            })
            ->onFailure(function () {
                \Log::error('NYTimes fetch job failed.');
            });

        // Schedule for NewsAPI
        $schedule->command('newsapi:test --country=us --category=business --source=newsapi')
            ->everyThreeHours()
            ->withoutOverlapping()
            ->before(function () {
                \Log::info('NewsAPI fetch job starting.');
            })
            ->after(function () {
                \Log::info('NewsAPI fetch job completed.');
            })
            ->onFailure(function () {
                \Log::error('NewsAPI fetch job failed.');
            });

        // Schedule for The Guardian API
        $schedule->command('guardianapi:fetch --section=technology --from-date=2024-01-01')
            ->everyTwoHours()
            ->withoutOverlapping()
            ->before(function () {
                \Log::info('Guardian fetch job starting.');
            })
            ->after(function () {
                \Log::info('Guardian fetch job completed.');
            })
            ->onFailure(function () {
                \Log::error('Guardian fetch job failed.');
            });
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
