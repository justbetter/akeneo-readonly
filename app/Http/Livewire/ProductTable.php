<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProductTable extends DataTableComponent
{
    public bool $columnSelect = true;

    public string $defaultSortColumn = 'identifier';

    public function columns(): array
    {
        return [
            Column::make('Identifier')
                ->searchable(),
            Column::make('Enabled'),
            Column::make('Type'),
            Column::make('Family')
                ->searchable(),
            Column::make('Created At'),
            Column::make('Updated At'),
            //Column::blank()
        ];
    }

    public function query()
    {
        return Product::with('attributes');
    }
}
