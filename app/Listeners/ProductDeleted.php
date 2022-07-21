<?php

namespace App\Listeners;

use App\Actions\Product\DeleteProduct;
use JustBetter\Akeneo\Events\ProductRemoved as Event;
use JustBetter\Akeneo\Models\Product;

class ProductDeleted
{
    public function __construct(
        public DeleteProduct $deleteProduct
    ) {
    }

    public function handle(Event $event): void
    {
        $akeneoProduct = new Product($event->event['data']['resource']);

        $this->deleteProduct->delete($akeneoProduct['identifier']);
    }
}
