<?php

namespace App\Actions\Product;

use App\Models\Attribute;
use App\Models\Product;

class TruncateProducts
{
    public function handle(): void
    {
        Product::query()->truncate();
        Attribute::query()->truncate();
    }
}
