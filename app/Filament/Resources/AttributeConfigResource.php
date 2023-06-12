<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeConfigResource\Pages;
use App\Models\AttributeConfig;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns;

class AttributeConfigResource extends Resource
{
    public static string $icon = 'heroicon-o-cog';

    public static function form(Form $form): Form
    {
        $importFilterFields = [
            Checkbox::make('import_filter_enabled')
                ->name('Use this attribute for filtering products that are imported')
                ->helperText('Enable import filter'),

            Select::make('import_filter_operator')
                ->name('Operator')
                ->options([
                    '=' => '=',
                    '!=' => '!=',
                    '>' => '>',
                    '<' => '<',
                    '<=' => '<=',
                    '>=' => '>=',
                    'IN' => 'IN',
                    'NOT IN' => 'NOT IN',
                ]),

            TextInput::make('import_filter_value')
                ->name('Value')
                ->helperText('Use comma seperated values for IN operators'),

            TextInput::make('import_filter_scope')
                ->name('Scope')
                ->helperText('Optional, fill in for scopable attributes'),

            TextInput::make('import_filter_locale')
                ->name('Locale')
                ->helperText('Optional, fill in for localizable attributes'),

        ];

        return $form
            ->schema([
                Card::make([
                    TextInput::make('code')
                        ->disabled(),

                    TextInput::make('sort')
                        ->numeric(),

                    Checkbox::make('searchable')
                        ->helperText('Make searchable'),

                    Checkbox::make('visible')
                        ->helperText('Visible on the detail page'),

                    Checkbox::make('grid')
                        ->helperText('Visible in the main grid'),

                    Checkbox::make('title')
                        ->helperText('Use as title'),

                    Checkbox::make('description')
                        ->helperText('Use as description'),

                ]),

                Card::make($importFilterFields),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('code')
                    ->searchable(),

                Columns\TextColumn::make('group')
                    ->getStateUsing(fn (AttributeConfig $record) => $record->data['group']),

                Columns\TextColumn::make('type')
                    ->getStateUsing(fn (AttributeConfig $record) => $record->data['type']),

                Columns\BooleanColumn::make('visible')
                    ->sortable(),

                Columns\BooleanColumn::make('grid')
                    ->sortable(),

                Columns\BooleanColumn::make('searchable')
                    ->sortable(),

                Columns\BooleanColumn::make('title')
                    ->sortable(),

                Columns\BooleanColumn::make('description')
                    ->sortable(),

                Columns\TextColumn::make('sort'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttributeConfigs::route('/'),
            'create' => Pages\CreateAttributeConfig::route('/create'),
            'edit' => Pages\EditAttributeConfig::route('/{record}/edit'),
        ];
    }
}
