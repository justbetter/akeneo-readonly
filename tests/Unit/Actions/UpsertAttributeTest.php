<?php

namespace Tests\Unit\Actions;

use App\Actions\Attribute\UpsertAttribute;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JustBetter\Akeneo\Models\Product as AkeneoProduct;
use Tests\TestCase;

class UpsertAttributeTest extends TestCase
{
    use RefreshDatabase;

    protected Product $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->createOne();
    }

    public function test_it_creates_attribute()
    {
        $akeneoProduct = $this->getAkeneoProduct();

        app(UpsertAttribute::class)->upsert($akeneoProduct, $this->product);

        $this->assertDatabaseCount(Attribute::class, 2);

        $created = $this->product->attributes()->get();

        foreach (['attribute', 'attribute2'] as $code) {
            $this->assertEquals(
                $akeneoProduct['values'][$code],
                $created->where('code', $code)->first()->value
            );
        }
    }

    public function test_it_upserts_attribute()
    {
        $akeneoProduct = $this->getAkeneoProduct();

        app(UpsertAttribute::class)->upsert($akeneoProduct, $this->product);

        $akeneoProduct['values'] = [
            'attribute' => [
                [
                    'data' => 'testing3',
                    'scope' => null,
                    'locale' => null
                ]
            ],
            'attribute2' => [
                [
                    'data' => 'testing2',
                    'scope' => 'ecommerce',
                    'locale' => 'nl_NL'
                ]
            ]
        ];

        app(UpsertAttribute::class)->upsert($akeneoProduct, $this->product);

        $this->assertDatabaseCount(Attribute::class, 2);

        $created = $this->product->attributes()->get();

        foreach (['attribute', 'attribute2'] as $code) {
            $this->assertEquals(
                $akeneoProduct['values'][$code],
                $created->where('code', $code)->first()->value
            );
        }
    }

    protected function getAkeneoProduct(): AkeneoProduct
    {
        return new AkeneoProduct([
            'values' => [
                'attribute' => [
                    [
                        'data' => 'testing',
                        'scope' => null,
                        'locale' => null
                    ]
                ],
                'attribute2' => [
                    [
                        'data' => 'testing2',
                        'scope' => 'ecommerce',
                        'locale' => 'nl_NL'
                    ]
                ]
            ]
        ]);
    }

}
