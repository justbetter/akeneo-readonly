<?php

namespace App\Console\Commands;

use App\Jobs\RetrieveAttributeConfigsJob;
use Illuminate\Console\Command;

class RetrieveAttributeConfigsCommand extends Command
{
    protected $signature = 'retrieve:attribute:configs';
    protected $description = 'Retrieve attributes to fill the configs table';

    public function handle(): int
    {
        RetrieveAttributeConfigsJob::dispatch();

        return static::SUCCESS;
    }
}
