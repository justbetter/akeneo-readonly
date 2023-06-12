<?php

namespace App\Http\Livewire;

use App\Integrations\Datatable\Columns\AttributeColumn;
use App\Models\AttributeConfig;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProductTable extends DataTableComponent
{
    protected array $searchableTypes = [
        'pim_catalog_identifier',
        'pim_catalog_text',
        'pim_catalog_simpleselect',
    ];

    protected array $searchables = [];

    /** @var array<string, string> */
    protected $listeners = [
        'update-locale' => '$refresh',
    ];

    public ?string $defaultSortColumn = 'identifier';

    public function configure(): void
    {
        $this
            ->setPrimaryKey('identifier')
            ->setTableRowUrl(function (Product $product) {
                return route('product.detail', $product->identifier);
            });
    }

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

        $this->searchables = $attributes->where('searchable', true)->toArray();

        $locale = auth()->user()->preferred_locale;

        /** @var AttributeConfig $attribute */
        foreach ($attributes as $attribute) {
            $columns[] = AttributeColumn::make($this->getLabel($attribute->code), $attribute->code, $attribute, $locale);
        }

        return $columns;
    }

    public function builder(): Builder
    {
        /** @return Builder */
        return Product::query()
            ->with('attributes');
        //->when($this->getFilter('search'), fn (Builder $query, string $term) => $query->search(strtolower($term), $this->searchables));
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

    public function applySearch(): Builder
    {
        $builder = $this->getBuilder();

        if ($this->searchIsEnabled() && $this->hasSearch()) {
            $searchQuery = $this->getSearch();

            $builder->whereHas('attributes', function (Builder $query) use ($searchQuery) {
                $query
                    ->join('attribute_configs', function (JoinClause $join) {
                        $join
                            ->on('attribute_configs.code', '=', 'attributes.code')
                            ->where('attribute_configs.searchable', '=', 1);
                    })
                     ->where('value', 'LIKE', "%$searchQuery%");
            });
        }

        return $builder;
    }

    public function getSelectableColumns(): Collection
    {
        return collect();
    }
}
