<?php

namespace App\Actions\Product;

use App\Actions\Attribute\UpsertAttribute;
use App\Exceptions\NotSupportedException;
use App\Models\Product;
use JustBetter\Akeneo\Models\Product as AkeneoProduct;

class UpsertProduct
{
    public function __construct(
        public UpsertAttribute $upsertAttribute
    )
    {
    }

    public function upsert(AkeneoProduct $akeneoProduct): Product
    {
        if ($akeneoProduct['parent'] !== null) {
            throw new NotSupportedException('Product models not supported');
        }

        /** @var Product $product */
        $product = Product::query()->updateOrCreate(
            [
                'identifier' => $akeneoProduct['identifier'],
            ],
            $akeneoProduct->toArray(),
        );

        $this->upsertAttribute->upsert($akeneoProduct, $product);

        return $product;
    }
}
