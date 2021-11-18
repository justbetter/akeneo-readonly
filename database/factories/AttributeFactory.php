<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class AttributeFactory extends Factory
{
    const SCOPES = [
        'ecommerce',
        'print'
    ];

    const LOCALES = [
        'en_US',
        'nl_NL'
    ];

    const GROUPS = [
        'general',
        'logistics',
        'measurements',
        'technical',
        'other'
    ];

    const TYPES = [
        'pim_catalog_text',
        'pim_catalog_textarea',
        'pim_catalog_boolean',
        'pim_catalog_number',
        'pim_catalog_simpleselect',
        'pim_catalog_multiselect',
        'pim_catalog_price_collection',
        'pim_catalog_metric'
    ];

    public function definition()
    {
        $type = Arr::random(self::TYPES);

        return [
            'code' => $this->faker->word,
            'group' => Arr::random(self::GROUPS),
            'type' => $type,
            'value' => $this->getValues($type)
        ];
    }

    protected function getValues(string $type): array
    {
        $values = [];

        foreach(self::SCOPES as $scope) {
            foreach (self::LOCALES as $locale) {

                $values[] = [
                    'scope' => random_int(0, 1) == 0 ? $scope : null,
                    'locale' => random_int(0, 1) == 0 ? $locale : null,
                    'value' => $this->randomValue($type)
                ];

            }
        }

        return $values;
    }

    protected function randomValue(string $type): array|string
    {
        return match($type) {
            'pim_catalog_text' => $this->faker->word,
            'pim_catalog_textarea' => $this->faker->text,
            'pim_catalog_boolean' => $this->faker->boolean,
            'pim_catalog_number' => $this->faker->numberBetween(0, 200),
            'pim_catalog_simpleselect' => $this->faker->word,
            'pim_catalog_multiselect' => $this->faker->words(3, false),
            'pim_catalog_price_collection' => [
                'currency' => 'EUR',
                'value' => $this->faker->randomFloat(2, 0, 200)
            ],
            'pim_catalog_metric' => [
                'unit' => Arr::random(['gram', 'kilogram', 'meter', 'kilometer']),
                'value' => $this->faker->randomFloat(2, 0, 200)
            ]
        };
    }
}
