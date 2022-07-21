<?php

namespace App\Console\Commands;

use App\Jobs\RetrieveProductJob;
use Illuminate\Console\Command;

class RetrieveProductCommand extends Command
{
    protected $signature = 'retrieve:product {identifier}';
    protected $description = 'Retrieve a single product from Akeneo';

    public function handle(): int
    {
        RetrieveProductJob::dispatch(
            $this->argument('identifier')
        );

        return static::SUCCESS;
    }
}
