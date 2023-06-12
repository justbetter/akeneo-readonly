<?php

namespace App\Http\Livewire\Product;

use App\Akeneo\ValueRetriever;
use App\Models\AttributeConfig;
use App\Models\Product;
use Illuminate\View\View;
use Livewire\Component;

class Header extends Component
{
    public Product $product;

    /** @var array<string, string> */
    protected $listeners = [
        'update-locale' => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.product.header');
    }

    public function getTitle(): string
    {
        $title = AttributeConfig::title()->first();

        if ($title === null) {
            return 'No title attribute set!';
        }

        return $this->getAttributeValue($title);
    }

    public function getDescription(): string
    {
        $description = AttributeConfig::description()->first();

        if ($description === null) {
            return 'No description attribute set!';
        }

        return $this->getAttributeValue($description);
    }

    protected function getAttributeValue(AttributeConfig $attributeConfig): string
    {
        $attribute = $this->product
            ->attributes()
            ->where('code', '=', $attributeConfig->code)
            ->first();

        if ($attribute === null) {
            return 'Product doesn\'t have '.$attributeConfig->code;
        }

        $userLocale = auth()->user()->preferred_locale ?? '';

        $scope = $attributeConfig->data['scopable'] ? config('app.channel') : null;
        $locale = $attributeConfig->data['localizable'] ? auth()->user()->preferred_locale : null;

        $value = ValueRetriever::retrieve($attributeConfig->code, $attributeConfig->data['type'], $attribute->value, $scope, $locale);

        if (is_string($value)) {
            return trim($value);
        }

        return $value[$userLocale] ?? '';
    }
}
