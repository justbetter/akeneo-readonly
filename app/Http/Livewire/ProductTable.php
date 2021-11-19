<?php

namespace App\Http\Livewire;

use App\Models\Attribute;
use App\Models\AttributeConfig;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use JustBetter\Akeneo\Models\Attribute as AkeneoAttribute;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProductTable extends DataTableComponent
{
    public bool $columnSelect = true;

    public string $defaultSortColumn = 'identifier';

    public function columns(): array
    {
        $columns = [
            Column::make('Identifier')
                ->searchable(),

            Column::make('Enabled')
                ->format(function ($value) {
                    return view('tables.cells.boolean',
                        [
                            'boolean' => $value
                        ]
                    );
                }),

        ];

        $attributes = AttributeConfig::grid()->get();

        /** @var Attribute $attribute */
        foreach ($attributes as $attribute) {

            $columns[] = Column::make($this->getLabel($attribute->code))
                ->format(function ($value, $column, $row) use ($attribute) {
                    $attr = $row->attributes()->where('code', $attribute->code)->first();

                    if ($attr === null) {
                        return __('No Value');
                    }

                    // TODO: Support languages
                    $data = Arr::first($attr->value)['data'];

                    return is_array($data)
                        ? $this->getValue($attribute, $data)
                        : $data;

                });
        }

        return $columns;
    }

    public function query()
    {
        return Product::with('attributes');
    }

    protected function getValue(AttributeConfig $attribute, array $data): string
    {
        $type = $attribute->data['type'] ?? null;

        return match($type) {
            'pim_catalog_multiselect' => implode(', ', $data),
            'pim_catalog_price_collection' => $data['currency'] . ' ' . $data['amount'],
            'pim_catalog_metric' => $data['amount'] . ' ' . $data['unit'],
            default => json_encode($data)
        };
    }

    /** Get front-end label from Akeneo */
    protected function getLabel(string $code): string
    {
        $labels = AttributeConfig::where('code', $code)->first()->data['labels'];

        // TODO: Support languages
        return Arr::first($labels);
    }

    // TODO
    //public function getTableRowUrl($row): string
    //{
    //    //return route('my.edit.route', $row);
    //}
}
