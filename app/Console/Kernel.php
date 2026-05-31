<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('ads:sync-all --platform=meta')
            ->hourly()
            ->withoutOverlapping(10)
            ->onOneServer()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/ads-sync.log'));

        $schedule->command('ads:sync-all --platform=all')
            ->dailyAt('03:00')
            ->withoutOverlapping(30)
            ->onOneServer()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/ads-sync.log'));

        $schedule->command('ads:health-check')
            ->everyFifteenMinutes()
            ->withoutOverlapping(5)
            ->onOneServer()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/ads-health.log'));

        $schedule->command('ads:spend-monitor')
            ->everyThirtyMinutes()
            ->withoutOverlapping(10)
            ->onOneServer()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/ads-spend.log'));

        $schedule->command('ads:health-check --platform=all')
            ->dailyAt('06:00')
            ->withoutOverlapping(15)
            ->onOneServer()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/ads-health.log'));
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
