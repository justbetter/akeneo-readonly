<?php

namespace App\Listeners;

use App\Actions\Product\DeleteProduct;
use JustBetter\AkeneoClient\Events\ProductRemovedEvent;

class ProductDeleted
{
    public function __construct(
        public DeleteProduct $deleteProduct
    ) {
    }

    public function handle(ProductRemovedEvent $event): void
    {
        $this->deleteProduct->delete($event->event['data']['resource']['identifier']);
    }
}
