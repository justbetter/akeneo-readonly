<?php

namespace App\Http\Livewire\Product;

use App\Akeneo\ValueRetriever;
use App\Models\AttributeConfig;
use App\Models\Product;
use Illuminate\Support\Arr;
use Livewire\Component;

class AttributeGroup extends Component
{
    protected $listeners = [
        'update-locale' => '$refresh',
    ];

    public Product $product;

    public string $group;

    public array $labels;

    public array $akeneoAttributes = [];

    public function mount()
    {
        $this->akeneoAttributes = $this->product->getAttributesPerGroup()[$this->group] ?? [];
    }

    public function render()
    {
        return view('livewire.product.attribute-group');
    }

    public function getHeader(): string
    {
        $locale = auth()->user()->preferred_locale;

        return trim(array_key_exists($locale, $this->labels)
            ? $this->labels[$locale]
            : Arr::first($this->labels));
    }

    public function getAttributeLabel(array $labels): string
    {
        $locale = auth()->user()->preferred_locale;

        return trim(array_key_exists($locale, $labels)
            ? $labels[$locale]
            : Arr::first($labels));
    }

    public function getAttributeValue(string $code): string|array
    {
        $config = AttributeConfig::where('code', $code)->first();
        $localizable = $config->data['localizable'];
        $scopable = $config->data['scopable'];

        $attribute = $this->product->attributes()
            ->where('code', $code)
            ->first();

        if ($attribute === null) {
            return '';
        }

        $userLocale = auth()->user()->preferred_locale ?? '';

        $scope = $scopable ? config('app.channel') : null;
        $locale = $localizable ? auth()->user()->preferred_locale : null;

        $value = ValueRetriever::retrieve($code, $config->data['type'], $attribute->value, $scope, $locale);

        if (is_string($value)) {
            return trim($value);
        }

        return $value[$userLocale] ?? '';
    }
}
