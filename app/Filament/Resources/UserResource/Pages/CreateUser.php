<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    public static string $resource = UserResource::class;

    public function beforeCreate()
    {
        $this->record['password'] = bcrypt($this->record['password']);
    }
}
