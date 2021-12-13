<?php

namespace App\Console\Commands;

use App\Jobs\RetrieveAttributeConfigs;
use App\Jobs\RetrieveProducts;
use Illuminate\Console\Command;

class Setup extends Command
{
    protected $signature = 'setup';

    protected $description = 'Retrieve all attributes and products';

    public function handle()
    {
        $this->info('Retrieving all attributes from Akeneo');

        RetrieveAttributeConfigs::dispatchSync();

        $this->info('Attributes retrieved!');

        $this->info('Dispatching jobs to retrieve products');

        RetrieveProducts::dispatch();

        $this->info('Done! Check horizon for the progress');

        return Command::SUCCESS;
    }
}
