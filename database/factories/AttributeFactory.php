<?php

namespace Database\Factories;

use App\Models\AttributeConfig;
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

    const CODES = [
        'attribute_1',
        'attribute_2',
        'attribute_3',
        'attribute_4',
        'attribute_5',
        'attribute_6',
        'attribute_7',
        'attribute_8',
        'attribute_9'
    ];

    public function definition()
    {
        $code = Arr::random(self::CODES);

        $config = $this->getAttributeConfig($code);

        return [
            'code' => $code,
            'value' => $this->getValues($config->data['type'])
        ];
    }

    protected function getAttributeConfig(string $code): AttributeConfig
    {
        $config = AttributeConfig::where('code', $code)->first();

        if ($config === null) {
            $config = AttributeConfig::create([
                'code' => $code,
                'data' => [
                    'type' => Arr::random(self::TYPES),
                    'group' => Arr::random(self::GROUPS),
                    'localizable' => random_int(0, 1) == 0,
                    'scopable' => random_int(0, 1) == 0,
                    'labels' => [
                        'nl_NL' => 'NL ' . $code,
                        'en_US' => 'EN ' . $code
                    ]
                ],
                'grid' => random_int(0, 1) == 0,
                'visible' => random_int(0, 10) < 8
            ]);
        }

        return $config;
    }

    protected function getValues(string $type): array
    {
        $values = [];

        foreach (self::SCOPES as $scope) {
            foreach (self::LOCALES as $locale) {

                $values[] = [
                    'scope' => random_int(0, 1) == 0 ? $scope : null,
                    'locale' => random_int(0, 1) == 0 ? $locale : null,
                    'data' => $this->randomValue($type)
                ];

            }
        }

        return $values;
    }

    protected function randomValue(string $type): array|string
    {
        return match ($type) {
            'pim_catalog_text' => $this->faker->word,
            'pim_catalog_textarea' => $this->faker->text,
            'pim_catalog_boolean' => $this->faker->boolean,
            'pim_catalog_number' => $this->faker->numberBetween(0, 200),
            'pim_catalog_simpleselect' => $this->faker->word,
            'pim_catalog_multiselect' => $this->faker->words(3, false),
            'pim_catalog_price_collection' => [
                'currency' => 'EUR',
                'amount' => $this->faker->randomFloat(2, 0, 200)
            ],
            'pim_catalog_metric' => [
                'unit' => Arr::random(['gram', 'kilogram', 'meter', 'kilometer']),
                'amount' => $this->faker->randomFloat(2, 0, 200)
            ]
        };
    }
}
