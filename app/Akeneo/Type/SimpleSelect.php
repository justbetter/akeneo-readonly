<?php

namespace App\Akeneo\Type;

use Illuminate\Support\Facades\Cache;
use JustBetter\Akeneo\Facades\Akeneo;
use JustBetter\Akeneo\Models\Attribute;

class SimpleSelect extends AbstractType
{
    public function types(): array
    {
        return [
            'pim_catalog_simpleselect'
        ];
    }

    public function retrieve(string $attributeCode, array $data, ?string $scopable, ?string $localizable): string|array
    {
        $selectedOption = collect($data)
            ->where('scopable', $scopable)
            ->where('localizable', $localizable)
            ->first();

        if ($selectedOption === null) {
            return '';
        }

        return $this->getLabels($attributeCode, $selectedOption['data']);
    }

    protected function getLabels(string $attributeCode, string $optionCode)
    {
        return Cache::rememberForever("labels.$attributeCode.$optionCode",
            fn() => Akeneo::getAttributeOptionApi()->get($attributeCode, $optionCode)['labels']);
    }
}
