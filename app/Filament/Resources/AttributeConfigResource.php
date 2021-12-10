<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeConfigResource\Pages;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Table;
use Filament\Tables\Columns\Boolean;

class AttributeConfigResource extends Resource
{
    public static $icon = 'heroicon-o-cog';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                TextInput::make('record.code')
                    ->disabled(),

                TextInput::make('record.sort')
                    ->numeric(),

                Checkbox::make('record.visible')
                    ->helpMessage('Visible on the detail page'),

                Checkbox::make('record.grid')
                    ->helpMessage('Visible in the main grid'),

                Checkbox::make('record.title')
                    ->helpMessage('Use as title'),

                Checkbox::make('record.description')
                    ->helpMessage('Use as description'),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('code')
                    ->searchable(),

                Columns\Text::make('group')
                    ->getValueUsing(fn($attr) => $attr->data['group']),

                Columns\Text::make('type')
                    ->getValueUsing(fn($attr) => $attr->data['type']),

                Boolean::make('visible')
                    ->sortable(),

                Boolean::make('grid')
                    ->sortable(),

                Boolean::make('title')
                    ->sortable(),

                Boolean::make('description')
                    ->sortable(),

                Columns\Text::make('sort')
            ]);
    }

    public static function routes()
    {
        return [
            Pages\ListAttributeConfigs::routeTo('/', 'index'),
            Pages\CreateAttributeConfig::routeTo('/create', 'create'),
            Pages\EditAttributeConfig::routeTo('/{record}/edit', 'edit'),
        ];
    }

}
