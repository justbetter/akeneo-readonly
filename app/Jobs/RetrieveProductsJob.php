<?php

namespace App\Jobs;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\Akeneo\Models\Product as AkeneoProduct;

class RetrieveProductsJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function handle(): void
    {
        Product::query()->truncate();
        Attribute::query()->truncate();

        AkeneoProduct::lazy()->each(function (AkeneoProduct $product): void {

            RetrieveProductJob::dispatch($product['identifier'], $product);

        });
    }
}
