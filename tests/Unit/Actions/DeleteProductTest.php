<?php

namespace Tests\Unit\Actions;

use App\Actions\Product\DeleteProduct;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_a_product(): void
    {
        $identifier = '::identifier::';

        Product::factory()->createOne([
            'identifier' => $identifier,
        ]);

        $this->assertDatabaseCount(Product::class, 1);

        /** @var DeleteProduct $action */
        $action = app(DeleteProduct::class);

        $action->delete($identifier);

        $this->assertDatabaseCount(Product::class, 0);
    }
}
