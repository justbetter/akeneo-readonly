<?php

namespace App\Akeneo\Type;

use Illuminate\Support\Facades\Cache;
use JustBetter\Akeneo\Facades\Akeneo;

class SimpleSelect extends AbstractType
{
    public function types(): array
    {
        return [
            'pim_catalog_simpleselect',
        ];
    }

    public function retrieve(string $attributeCode, array $data, ?string $scope, ?string $locale): string|array
    {
        $selectedOption = collect($data)
            ->where('scope', $scope)
            ->where('locale', $locale)
            ->first();

        if ($selectedOption === null) {
            return '';
        }

        return $this->getLabels($attributeCode, $selectedOption['data']);
    }

    protected function getLabels(string $attributeCode, string $optionCode)
    {
        return Cache::remember("labels.$attributeCode.$optionCode", now()->addDay(),
            fn () => Akeneo::getAttributeOptionApi()->get($attributeCode, $optionCode)['labels']);
    }
}
