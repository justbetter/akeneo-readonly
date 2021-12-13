<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use Filament\Forms\Components\Checkbox;
use Filament\Resources\Forms\Components\TextInput;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Table;
use Filament\Tables\Columns\Boolean;
use Filament\Tables\Columns\Text;

class UserResource extends Resource
{
    public static $icon = 'heroicon-o-users';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->email()
                    ->required(),

                Checkbox::make('record.admin'),

                TextInput::make('password')
                    ->password(),

            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Text::make('name'),
                Text::make('email'),
                Boolean::make('admin')
                    ->label('Administrator?'),
            ])
            ->filters([
                //
            ]);
    }

    public static function relations()
    {
        return [
            //
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListUsers::routeTo('/', 'index'),
            Pages\CreateUser::routeTo('/create', 'create'),
            Pages\EditUser::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
