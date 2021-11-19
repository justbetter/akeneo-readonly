<?php

namespace App\Console\Commands;

use App\Jobs\RetrieveAttributeConfigs as RetrieveAttributeConfigsJob;
use Illuminate\Console\Command;

class RetrieveAttributeConfigs extends Command
{
    protected $signature = 'retrieve:attribute:configs';

    protected $description = 'Retrieve attributes to fill the configs table';

    public function handle()
    {
        RetrieveAttributeConfigsJob::dispatch();

        return Command::SUCCESS;
    }
}
