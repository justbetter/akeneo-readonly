<?php

namespace App\Http\Livewire;

use App\Models\Attribute;
use App\Models\AttributeConfig;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProductTable extends DataTableComponent
{
    protected array $searchableTypes = [
        'pim_catalog_identifier',
        'pim_catalog_text',
        'pim_catalog_simpleselect',
    ];

    protected $listeners = [
        'update-locale' => '$refresh',
    ];

    public string $defaultSortColumn = 'identifier';

    public function columns(): array
    {
        $columns = [
            Column::make('Enabled')
                ->format(function ($value) {
                    return view('tables.cells.boolean',
                        [
                            'boolean' => $value,
                        ]
                    );
                }),
        ];

        $attributes = AttributeConfig::grid()->get();

        $locale = auth()->user()->preferred_locale;

        /** @var Attribute $attribute */
        foreach ($attributes as $attribute) {
            $column = Column::make($this->getLabel($attribute->code), $attribute->code)
                ->format(function ($value, $column, $row) use ($attribute, $locale, &$searchable) {
                    $type = $attribute->data['type'];

                    if ($type == 'pim_catalog_identifier') {
                        return $row['identifier'];
                    }

                    $attr = $row->attributes()->where('code', $attribute->code)->first();

                    if ($attr === null) {
                        return __('No Value');
                    }

                    $data = $this->getLocalizedAttribute($attr->value, $locale)['data'];

                    if ($type == 'pim_catalog_image') {
                        return view('tables.cells.image', ['url' => $this->getImageUrl($attr)]);
                    }

                    return is_array($data)
                        ? $this->getValue($attribute, $data)
                        : $data;
                });

            if (in_array($attribute->data['type'], $this->searchableTypes)) {
                $column->searchable([$this, 'search']);
            }

            $columns[] = $column;
        }

        return $columns;
    }

    public function search(Builder $query, string $search)
    {
        return $query->where('identifier', 'LIKE', "%{$search}%");
    }

    public function query()
    {
        return Product::with('attributes');
    }

    protected function getLocalizedAttribute(array $attributeValues, ?string $locale = null): array
    {
        if ($locale == null) {
            $locale = auth()->user()->preferred_locale;
        }

        foreach ($attributeValues as $value) {
            if ($value['locale'] === $locale) {
                return $value;
            }
        }

        return Arr::first($attributeValues);
    }

    protected function getValue(AttributeConfig $attribute, array $data): string
    {
        $type = $attribute->data['type'] ?? null;

        return match ($type) {
            'pim_catalog_multiselect' => implode(', ', $data),
            'pim_catalog_price_collection' => $data['currency'].' '.$data['amount'],
            'pim_catalog_metric' => $data['amount'].' '.$data['unit'],
            default => json_encode($data)
        };
    }

    /** Get localized label from Akeneo config */
    protected function getLabel(string $code): string
    {
        $labels = AttributeConfig::where('code', $code)->first()->data['labels'];

        $locale = auth()->user()->preferred_locale;

        return $locale !== null && isset($labels[$locale])
            ? $labels[$locale]
            : Arr::first($labels);
    }

    protected function getImageUrl(Attribute $attribute): string
    {
        $image = $this->getLocalizedAttribute($attribute->value);

        return route('product.image', ['code' => $image['data'], 'width' => 48, 'height' => 48]);
    }

    public function getTableRowUrl(Product $product): string
    {
        return route('product.detail', $product->identifier);
    }
}
