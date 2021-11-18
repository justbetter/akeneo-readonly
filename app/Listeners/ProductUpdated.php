<?php

namespace App\Listeners;

use App\Actions\Product\UpsertProduct;
use JustBetter\Akeneo\Events\ProductUpdated as ProductUpdatedEvent;
use JustBetter\Akeneo\Models\Product;

class ProductUpdated
{
    public function handle(ProductUpdatedEvent $event)
    {
        $akeneoProduct = new Product($event->event['data']['resource']);

         app(UpsertProduct::class)->upsert($akeneoProduct);
    }
}
