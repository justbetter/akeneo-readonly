<?php

namespace App\Actions\Product;

use App\Actions\Attribute\UpsertAttribute;
use App\Exceptions\NotSupportedException;
use App\Models\Product;
use JustBetter\Akeneo\Models\Product as AkeneoProduct;

class UpsertProduct
{
    public function upsert(AkeneoProduct $akeneoProduct, bool $createAttributes = true): ?Product
    {
        $identifier = $akeneoProduct[$akeneoProduct->primaryKey];

        throw_if($akeneoProduct['parent'] !== null,
            NotSupportedException::class,
            "Productmodels not supported");

        $product = Product::updateOrCreate(
            ['identifier' => $identifier],
            $akeneoProduct->toArray()
        );

        if ($createAttributes) {
            app(UpsertAttribute::class)->upsert($this->akeneoProduct, $product);
        }

        return $product;
    }
}
