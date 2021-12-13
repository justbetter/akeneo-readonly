<?php

namespace App\Akeneo\Type;

class Simple extends AbstractType
{
    public function types(): array
    {
        return [
            'pim_catalog_text',
            'pim_catalog_textarea',
            'pim_catalog_boolean',
            'pim_catalog_number',
        ];
    }

    public function retrieve(string $attributeCode, array $data, ?string $scope, ?string $locale): string|array
    {
        return collect($data)
                ->where('scope', $scope)
                ->where('locale', $locale)
                ->first()['data'] ?? '';
    }
}
