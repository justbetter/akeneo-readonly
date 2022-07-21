<?php

namespace App\Console;

use App\Console\Commands\RetrieveAttributeConfigsCommand;
use App\Console\Commands\RetrieveProductsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(RetrieveAttributeConfigsCommand::class)->weeklyOn(1);
        $schedule->command(RetrieveProductsCommand::class)->weeklyOn(2);

        $schedule->command('horizon:snapshot')->everyFiveMinutes();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
