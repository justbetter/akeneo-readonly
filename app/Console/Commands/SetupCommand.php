<?php

namespace App\Console\Commands;

use App\Jobs\RetrieveAttributeConfigsJob;
use App\Jobs\RetrieveProductsJob;
use Illuminate\Console\Command;

class SetupCommand extends Command
{
    protected $signature = 'setup';
    protected $description = 'Retrieve all attributes and products';

    public function handle(): int
    {
        $this->line('Retrieving all attributes from Akeneo');

        RetrieveAttributeConfigsJob::dispatchSync();

        $this->info('Attributes retrieved!');

        $this->line('Dispatching jobs to retrieve products');

        RetrieveProductsJob::dispatch();

        $this->info('Done! Check horizon for the progress');

        return static::SUCCESS;
    }
}
