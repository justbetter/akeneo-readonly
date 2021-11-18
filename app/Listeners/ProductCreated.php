<?php

namespace App\Listeners;

use App\Actions\Product\UpsertProduct;
use JustBetter\Akeneo\Events\ProductCreated as ProductCreatedEvent;
use JustBetter\Akeneo\Models\Product;

class ProductCreated
{
    public function handle(ProductCreatedEvent $event)
    {
        $akeneoProduct = new Product($event->event['data']['resource']);

        app(UpsertProduct::class)->upsert($akeneoProduct);
    }
}
