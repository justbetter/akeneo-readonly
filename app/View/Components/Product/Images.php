<?php

namespace App\View\Components\Product;

use App\Models\Attribute;
use App\Models\AttributeConfig;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Images extends Component
{
    public array $images = [];

    public function __construct(
        public Product $product
    ) {
    }

    public function render()
    {
        return view('components.product.images');
    }

    public function getImages(): array
    {
        $imageAttributes = $this->getImageAttributes();

        return $this->product
            ->attributes()
            ->whereIn('code', $imageAttributes->pluck('code'))
            ->select(['code', 'value'])
            ->get()
            ->map(function (Attribute $attribute) use ($imageAttributes) {
                $config = $imageAttributes->where('code', '=', $attribute->code)->first();

                $scope = $config->data['scopable'] ? config('app.channel') : null;
                $locale = $config->data['localizable'] ? auth()->user()->preferred_locale : null;

                $image = collect($attribute->value)
                    ->where('scope', $scope)
                    ->where('locale', $locale)
                    ->first();

                return $image['data'];
            })
            ->toArray();
    }

    protected function getImageAttributes(): Collection
    {
        return AttributeConfig::query()
            ->where('data', 'LIKE', '%pim_catalog_image%')
            ->select(['code', 'data'])
            ->get();
    }
}
