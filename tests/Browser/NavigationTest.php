<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Artisan;

class NavigationTest extends DuskTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Create sqlite database and run migrations
        Artisan::call('migrate:fresh');
    }

    public function test_guest_can_see_landing_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                   ->assertSee('Welcome to Nerdle')
                   ->assertSee('Play')
                   ->assertSee('Login')
                   ->assertSee('Register');
        });
    }

    public function test_guest_can_navigate_to_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                   ->clickLink('Login')
                   ->assertPathIs('/login')
                   ->assertSee('Login');
        });
    }

    public function test_guest_can_navigate_to_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                   ->clickLink('Register')
                   ->assertPathIs('/register')
                   ->assertSee('Register');
        });
    }

    public function test_guest_can_start_game()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                   ->clickLink('Play')
                   ->assertPathIs('/game')
                   ->assertSee('Guess the Animal');
        });
    }
}
