<?php

namespace App\Listeners;

use App\Actions\Product\UpsertProduct;
use JustBetter\Akeneo\Events\ProductUpdated as Event;
use JustBetter\Akeneo\Models\Product;

class ProductUpdated
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
