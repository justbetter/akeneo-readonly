<?php

namespace App\Filament\Resources\AttributeConfigResource\Pages;

use App\Filament\Resources\AttributeConfigResource;
use App\Models\AttributeConfig;
use Filament\Resources\Pages\EditRecord;

class EditAttributeConfig extends EditRecord
{
    public static string $resource = AttributeConfigResource::class;

    public function beforeSave()
    {
        if ($this->record['title']) {
            AttributeConfig::query()->update(['title' => false]);
        }

        if ($this->record['description']) {
            AttributeConfig::query()->update(['description' => false]);
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['import_filter_enabled'] = $data['import_filter']['enabled'] ?? false;
        $data['import_filter_type'] = $data['import_filter']['type'] ?? '';
        $data['import_filter_value'] = $data['import_filter']['value'] ?? '';

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['import_filter'] = [
            'enabled' => true,
            'type' => $data['import_filter_type'],
            'value' => $data['import_filter_value'],
        ];

        unset($data['import_filter_enabled']);
        unset($data['import_filter_type']);
        unset($data['import_filter_value']);

        return $data;
    }
}
