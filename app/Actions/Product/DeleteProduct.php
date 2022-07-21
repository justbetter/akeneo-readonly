<?php

namespace App\Actions\Product;

use App\Models\Product;

class DeleteProduct
{
    public function delete(string $identifier): void
    {
        $product = Product::query()
            ->where('identifier', '=', $identifier)
            ->first();

        if ($product === null) {
            return;
        }

        $product->delete();
    }
}
