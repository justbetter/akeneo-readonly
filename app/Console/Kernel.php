<?php

namespace App\Console;

use App\Console\Commands\RetrieveAttributeConfigsCommand;
use App\Console\Commands\RetrieveProductsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\Health\Commands\ScheduleCheckHeartbeatCommand;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(RetrieveAttributeConfigsCommand::class)->weekly();
        $schedule->command(RetrieveProductsCommand::class)->weekly();

        $schedule->command(ScheduleCheckHeartbeatCommand::class)->everyMinute();
        $schedule->command(RunHealthChecksCommand::class)->everyMinute();

        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        $schedule->command('cache:prune-stale-tags')->hourly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
