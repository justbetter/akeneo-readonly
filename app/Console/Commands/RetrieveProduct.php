<?php

namespace App\Console\Commands;

use App\Jobs\RetrieveProduct as RetrieveProductJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class RetrieveProduct extends Command
{
    protected $signature = 'retrieve:product {identifier} {--now}';

    protected $description = 'Retrieve a single product from Akeneo';

    public function handle()
    {
        $identifier = $this->argument('identifier');

        $job = new RetrieveProductJob($identifier);

        if ($this->option('now')) {
            $this->info("Retrieving product {$identifier}");

            Bus::dispatchSync($job);

            $this->info('Finished!');
        } else {
            Bus::dispatch($job);
        }

        return Command::SUCCESS;
    }
}
