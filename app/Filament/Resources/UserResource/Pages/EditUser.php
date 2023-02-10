<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    public static string $resource = UserResource::class;

    public function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['password'] === null) {
            $data['password'] = $this->record->password;
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        return $data;
    }
}
