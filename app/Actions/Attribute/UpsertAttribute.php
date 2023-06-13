<?php

namespace App\Actions\Attribute;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Support\Collection;

class UpsertAttribute
{
    public function upsert(array $akeneoProduct, Product $product): Collection
    {
        /** @var Collection<int, Attribute> $createdAttributes */
        $createdAttributes = collect();

        foreach ($akeneoProduct['values'] as $code => $attributeData) {
            $data = [
                'product_id' => $product->id,
                'code' => $code,
                'value' => $attributeData,
            ];

            $createdAttributes[] = Attribute::query()
                ->updateOrCreate(
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
