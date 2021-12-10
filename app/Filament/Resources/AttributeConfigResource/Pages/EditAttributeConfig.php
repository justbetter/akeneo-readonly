<?php

namespace App\Filament\Resources\AttributeConfigResource\Pages;

use App\Filament\Resources\AttributeConfigResource;
use App\Models\AttributeConfig;
use Filament\Resources\Pages\EditRecord;

class EditAttributeConfig extends EditRecord
{
    public static $resource = AttributeConfigResource::class;

    public function beforeSave()
    {
        if ($this->record['title']) {
            AttributeConfig::query()->update(['title' => false]);
        }

        if ($this->record['description']) {
            AttributeConfig::query()->update(['description' => false]);
        }
    }
}
