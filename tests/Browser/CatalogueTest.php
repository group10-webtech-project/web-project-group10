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
                    ->assertPathIs('/catalogue')
                    ->waitFor('.input')
                    ->assertVisible('.input')
                    ->type('', 'Lion')
                    ->pause(1000)
                    ->waitFor('#selection_menu')
                    ->assertVisible('#selection_menu')
                    ->click('#selection_menu li:first-child')
                    ->waitFor('#animal_name')
                    ->assertSee('Lion')
                    ->assertVisible('#animal_image')
                    ->assertVisible('#info');
        });
    }
}
