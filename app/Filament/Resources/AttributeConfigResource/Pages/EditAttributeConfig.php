<?php

namespace App\Filament\Resources\AttributeConfigResource\Pages;

use App\Filament\Resources\AttributeConfigResource;
use App\Models\AttributeConfig;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditAttributeConfig extends EditRecord
{
    public static string $resource = AttributeConfigResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('delete')->hidden(true),
        ];
    }

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
        $data['import_filter_operator'] = $data['import_filter']['operator'] ?? '';
        $data['import_filter_value'] = $data['import_filter']['value'] ?? '';
        $data['import_filter_scope'] = $data['import_filter']['scope'] ?? '';
        $data['import_filter_locale'] = $data['import_filter']['locale'] ?? '';

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['import_filter'] = [
            'enabled' =>  $data['import_filter_enabled'],
            'operator' => $data['import_filter_operator'],
            'value' => $data['import_filter_value'],
            'scope' => $data['import_filter_scope'],
            'locale' => $data['import_filter_locale'],
        ];

        unset($data['import_filter_enabled']);
        unset($data['import_filter_operator']);
        unset($data['import_filter_value']);
        unset($data['import_filter_scope']);
        unset($data['import_filter_locale']);

        return $data;
    }
}
