<?php

namespace App\Listeners;

use App\Actions\Product\UpsertProduct;
use JustBetter\AkeneoClient\Events\ProductUpdatedEvent;

class ProductUpdated
{
    public function __construct(
        public UpsertProduct $upsertProduct
    ) {
    }

    public function handle(ProductUpdatedEvent $event): void
    {
        $this->upsertProduct->upsert($event->event['data']['resource']);
    }
}
