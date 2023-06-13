<?php

namespace App\Akeneo\Type;

use Illuminate\Support\Facades\Cache;
use JustBetter\AkeneoClient\Client\Akeneo;

class MultiSelect extends AbstractType
{
    public function __construct(protected Akeneo $akeneo)
    {
    }

    public function types(): array
    {
        return [
            'pim_catalog_multiselect',
        ];
    }

    public function retrieve(string $attributeCode, array $data, ?string $scope, ?string $locale): string|array
    {
        $selectedOptions = collect($data)
            ->where('scope', $scope)
            ->where('locale', $locale)
            ->first();

        if ($selectedOptions === null) {
            return '';
        }

        $labels = collect();

        foreach ($selectedOptions['data'] as $selectedOption) {
            foreach ($this->getLabels($attributeCode, $selectedOption) as $localeLabel => $label) {
                if ($labels->has($localeLabel)) {
                    $labels[$localeLabel] = array_merge($labels[$localeLabel], [$label]);
                } else {
                    $labels[$localeLabel] = [$label];
                }
            }
        }

        return $labels->toArray();
    }

    protected function getLabels(string $attributeCode, string $optionCode): array
    {
        return Cache::remember("labels.$attributeCode.$optionCode", now()->addDay(),
            fn () => $this->akeneo->getAttributeOptionApi()->get($attributeCode, $optionCode)['labels']);
    }
}
