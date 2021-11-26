<?php

namespace App\Console;

use App\Console\Commands\RetrieveProduct;
use App\Console\Commands\RetrieveProducts;
use App\Console\Commands\Setup;
use App\Console\Commands\UpdateProducts;
use App\Jobs\RetrieveAttributeConfigs;
use App\Jobs\RetrieveProducts as RetrieveProductsJob;
use App\Jobs\UpdateProducts as UpdateProductsJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Setup::class,
        RetrieveProduct::class,
        RetrieveProducts::class,
        UpdateProducts::class
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->job(RetrieveProductsJob::class)->weekly();
        $schedule->job(UpdateProductsJob::class)->weekly();
        $schedule->job(RetrieveAttributeConfigs::class)->weekly();

        $schedule->command('horizon:snapshot')->everyFiveMinutes();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
