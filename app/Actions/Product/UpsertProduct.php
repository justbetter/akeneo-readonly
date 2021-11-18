<?php

namespace App\Actions\Product;

use App\Exceptions\NotSupportedException;
use App\Models\Product;
use JustBetter\Akeneo\Models\Product as AkeneoProduct;

class UpsertProduct
{
    public function upsert(AkeneoProduct $product): Product
    {
        $identifier = $product[$product->primaryKey];

        throw_if($product['parent'] !== null,
            NotSupportedException::class,
            "Productmodels not supported");

        return Product::updateOrCreate(
            ['identifier' => $identifier],
            $product->toArray()
        );
    }
}
