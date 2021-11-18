<?php

namespace App\Console\Commands;

use App\Jobs\RetrieveProducts as RetrieveProductsJob;
use Illuminate\Console\Command;

class RetrieveProducts extends Command
{
    protected $signature = 'retrieve:products';

    protected $description = 'Retrieve all products from Akeneo';

    public function handle()
    {
        RetrieveProductsJob::dispatch();

        return Command::SUCCESS;
    }
}
