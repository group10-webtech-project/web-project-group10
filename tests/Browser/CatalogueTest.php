<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CatalogueTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCatalogueNavigation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Catalogue')
                    ->clickLink('Catalogue')
                    ->assertPathIs('/catalogue');
        });
    }
}
