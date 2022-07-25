<?php

namespace App\Filament\Resources\AttributeConfigResource\Pages;

use App\Filament\Resources\AttributeConfigResource;
use App\Models\AttributeConfig;
use Filament\Resources\Pages\CreateRecord;

class CreateAttributeConfig extends CreateRecord
{
    public static string $resource = AttributeConfigResource::class;

    public function beforeCreate()
    {
        if ($this->record['title']) {
            AttributeConfig::query()->update(['title' => false]);
        }

        if ($this->record['description']) {
            AttributeConfig::query()->update(['description' => false]);
        }
    }
}
