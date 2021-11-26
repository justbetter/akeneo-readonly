<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    public static $resource = UserResource::class;

    public function beforeSave()
    {
        if ($this->record->password === null) {
            $this->record->password = $this->record->getRawOriginal('password');
        } else {
            $this->record->password = bcrypt($this->record->password);
        }
    }
}
