<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductTableTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
        $this->artisan('db:seed --class=ProductSeeder');
    }

    public function testTable()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs( User::first());

            $browser->visit('/products')
                    ->assertSee('Showing 1 to 10 of 50 results');

            $browser->assertVisible('table');

            foreach (['nl_NL', 'en_US', 'de_DE'] as $language) {
                $browser->click("#language-$language");

                $browser->waitFor(".language-$language-active");
            }
        });
    }
}
