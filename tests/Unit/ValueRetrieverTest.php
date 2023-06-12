<?php

namespace Tests\Unit;

use App\Akeneo\Type\MultiSelect;
use App\Akeneo\Type\SimpleSelect;
use App\Akeneo\ValueRetriever;
use Mockery\MockInterface;
use Tests\TestCase;

class ValueRetrieverTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->partialMock(SimpleSelect::class, function (MockInterface $mock):void {
            $mock->shouldAllowMockingProtectedMethods();

            $mock->shouldReceive('getLabels')
                ->with('::simple_select_attribute::', '::some_option::')
                ->andReturn([
                    'nl_NL' => 'Some Option Label',
                ]);
        });

        $this->partialMock(MultiSelect::class, function (MockInterface $mock): void {
            $mock->shouldAllowMockingProtectedMethods();

            $mock->shouldReceive('getLabels')
                ->with('::multi_select_attribute::', '::some_option::')
                ->andReturn([
                    'nl_NL' => 'Some Option Label',
                ]);

            $mock->shouldReceive('getLabels')
                ->with('::multi_select_attribute::', '::another_option::')
                ->andReturn([
                    'nl_NL' => 'Another Option Label',
                ]);
        });
    }

    /**
     * @dataProvider values
     */
    public function test_it_retrieves_values(
        string $attributeCode,
        string $type,
        array $data,
        ?string $scope,
        ?string $locale,
        string|array $result
    ): void {
        $retrieved = ValueRetriever::retrieve(
            $attributeCode,
            $type,
            $data,
            $scope,
            $locale
        );

        $this->assertEquals($result, $retrieved);
    }

    public static function values(): array
    {
        return [
            [
                '::some_simple_attribute::',
                'pim_catalog_text',
                [
                    [
                        'data' => '::some_value::',
                        'scope' => null,
                        'locale' => null,
                    ],
                ],
                null,
                null,
                '::some_value::',
            ],
            [
                '::some_simple_attribute_with_locale::',
                'pim_catalog_text',
                [
                    [
                        'data' => '::some_value::',
                        'scope' => null,
                        'locale' => 'nl_NL',
                    ],
                ],
                null,
                'nl_NL',
                '::some_value::',
            ],
            [
                '::simple_select_attribute::',
                'pim_catalog_simpleselect',
                [
                    [
                        'data' => '::some_option::',
                        'scope' => null,
                        'locale' => 'nl_NL',
                    ],
                ],
                null,
                'nl_NL',
                ['nl_NL' => 'Some Option Label'],
            ],
            [
                '::multi_select_attribute::',
                'pim_catalog_multiselect',
                [
                    [
                        'data' => ['::some_option::', '::another_option::'],
                        'scope' => null,
                        'locale' => null,
                    ],
                ],
                null,
                null,
                ['nl_NL' => ['Some Option Label', 'Another Option Label']],
            ],
        ];
    }
}
