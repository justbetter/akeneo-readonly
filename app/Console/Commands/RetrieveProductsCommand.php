<?php

namespace App\Console\Commands;

use App\Jobs\RetrieveProductsJob;
use Illuminate\Console\Command;

class RetrieveProductsCommand extends Command
{
    protected $signature = 'retrieve:products';

    protected $description = 'Retrieve all products from Akeneo';

    public function handle(): int
    {
        RetrieveProductsJob::dispatch();

        return static::SUCCESS;
    }
}
