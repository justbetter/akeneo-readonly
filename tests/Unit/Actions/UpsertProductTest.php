<?php

namespace Tests\Unit\Actions;

use App\Actions\Product\UpsertProduct;
use App\Exceptions\NotSupportedException;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JustBetter\Akeneo\Models\Product as AkeneoProduct;
use Tests\TestCase;

class UpsertProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_product()
    {
        app(UpsertProduct::class)->upsert($this->getAkeneoProduct(), false);

        $this->assertDatabaseCount(Product::class, 1);
        $this->assertEquals('::identifier::', Product::first()->identifier);
    }

    public function test_it_upserts_product()
    {
        $product = $this->getAkeneoProduct();

        app(UpsertProduct::class)->upsert($product, false);

        $this->assertDatabaseCount(Product::class, 1);
        $this->assertEquals('::identifier::', Product::first()->identifier);
        $this->assertEquals('::family::', Product::first()->family);

        $product['family'] = '::family_2::';

        app(UpsertProduct::class)->upsert($product, false);

        $this->assertDatabaseCount(Product::class, 1);
        $this->assertEquals('::identifier::', Product::first()->identifier);
        $this->assertEquals('::family_2::', Product::first()->family);
    }

    public function test_it_dispatches_attribute_job()
    {
        app(UpsertProduct::class)->upsert($this->getAkeneoProduct());

        $this->assertDatabaseCount(Product::class, 1);
        $this->assertDatabaseCount(Attribute::class, 2);
    }

    public function test_it_does_not_support_product_models()
    {
        $this->expectException(NotSupportedException::class);

        app(UpsertProduct::class)->upsert($this->getAkeneoProduct(true));
    }

    protected function getAkeneoProduct(bool $withParent = false): AkeneoProduct
    {
        $data = [
            'identifier' => '::identifier::',
            'categories' => ['::category_1::', '::category_2::'],
            'family' => '::family::',
            'values' => [
                '::some_attribute_code::' => [
                    [
                        'data' => '::some_data::',
                        'scope' => null,
                        'locale' => null,
                    ],
                ],
                '::another_attribute_code::' => [
                    [
                        'data' => '::some_data::',
                        'scope' => null,
                        'locale' => null,
                    ],
                ],
            ],
        ];

        if ($withParent) {
            $data['parent'] = '::some_parent_identifier::';
        }

        return new AkeneoProduct($data);
    }
}
