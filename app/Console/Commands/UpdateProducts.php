<?php

namespace App\Console\Commands;

use App\Jobs\UpdateProducts as UpdateProductsJob;
use Illuminate\Console\Command;

class UpdateProducts extends Command
{
    protected $signature = 'update:products';

    protected $description = 'Update all products that are currently in the database';

    public function handle()
    {
        UpdateProductsJob::dispatch();

        return Command::SUCCESS;
    }
}
