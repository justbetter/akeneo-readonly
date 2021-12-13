<?php

namespace App\Listeners;

use App\Actions\Product\DeleteProduct;
use JustBetter\Akeneo\Events\ProductRemoved as ProductDeletedEvent;
use JustBetter\Akeneo\Models\Product;

class ProductDeleted
{
    public function handle(ProductDeletedEvent $event)
    {
        $akeneoProduct = new Product($event->event['data']['resource']);

        app(DeleteProduct::class)->delete($akeneoProduct[$akeneoProduct->primaryKey]);
    }
}
