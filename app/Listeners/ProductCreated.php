<?php

namespace App\Listeners;

use App\Actions\Product\UpsertProduct;
use JustBetter\Akeneo\Events\ProductCreated as Event;
use JustBetter\Akeneo\Models\Product;

class ProductCreated
{
    public function __construct(
        public UpsertProduct $upsertProduct
    ) {
    }

    public function handle(Event $event): void
    {
        $akeneoProduct = new Product($event->event['data']['resource']);

        $this->upsertProduct->upsert($akeneoProduct);
    }
}
