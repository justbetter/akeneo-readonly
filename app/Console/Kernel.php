<?php

namespace App\Console;

use App\Console\Commands\RetrieveProduct;
use App\Console\Commands\RetrieveProducts;
use App\Console\Commands\UpdateProducts;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        RetrieveProduct::class,
        RetrieveProducts::class,
        UpdateProducts::class
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command(RetrieveProducts::class)->weekly();
        $schedule->command(UpdateProducts::class)->weekly();

        // TOOD: snapshot
        // TOOD: batch prune
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
