<?php

namespace App\Actions\Product;

use App\Actions\Attribute\UpsertAttribute;
use App\Exceptions\NotSupportedException;
use App\Models\Product;

class UpsertProduct
{
    public function __construct(
        public UpsertAttribute $upsertAttribute
    ) {
    }

    public function upsert(array $akeneoProduct): Product
    {
        if (isset($akeneoProduct['parent'])) {
            throw new NotSupportedException('Product models not supported');
        }

        /** @var Product $product */
        $product = Product::query()->updateOrCreate(
            [
                'identifier' => $akeneoProduct['identifier'],
            ],
            $akeneoProduct,
        );

        $this->upsertAttribute->upsert($akeneoProduct, $product);

        return $product;
    }
}
