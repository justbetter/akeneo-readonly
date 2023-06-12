<?php

namespace App\Akeneo\Type;

use Illuminate\Support\Facades\Cache;
use JustBetter\AkeneoClient\Client\Akeneo;

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

    protected function getLabels(string $attributeCode, string $optionCode): array
    {
        return Cache::remember(
            "labels.$attributeCode.$optionCode",
            now()->addDay(),
            function () use ($attributeCode, $optionCode): array {
                /** @var Akeneo $akeneo */
                $akeneo = app(Akeneo::class);

                return $akeneo->getAttributeOptionApi()->get($attributeCode, $optionCode)['labels'];
            }
        );
    }
}
