<?php

namespace App\Actions\Attribute;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Support\Collection;
use JustBetter\Akeneo\Models\Product as AkeneoProduct;

class UpsertAttribute
{
    public function upsert(AkeneoProduct $akeneoProduct, Product $product): Collection
    {
        $createdAttributes = new Collection();

        foreach ($akeneoProduct['values'] as $code => $attributeData) {
            $data = [
                'product_id' => $product->id,
                'code' => $code,
                'value' => $attributeData,
            ];

            $createdAttributes[] = Attribute::query()->updateOrCreate(
                [
                    'product_id' => $product->id,
                    'code' => $code,
                ],
                $data
            );
        }

        return $createdAttributes;
    }
}
