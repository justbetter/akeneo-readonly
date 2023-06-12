<?php

namespace App\Listeners;

use App\Actions\Product\UpsertProduct;
use JustBetter\AkeneoClient\Events\ProductCreatedEvent;

class ProductCreated
{
    public function __construct(
        public UpsertProduct $upsertProduct
    ) {
    }

    public function handle(ProductCreatedEvent $event): void
    {
        $this->upsertProduct->upsert($event->event['data']['resource']);
    }
}
