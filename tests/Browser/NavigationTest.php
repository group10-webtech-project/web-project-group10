<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NavigationTest extends DuskTestCase
{
    public function testNavigation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(1000)
                ->click('.logo')
                ->assertPathIs('/login')
                ->assertSee('Login')
                ->clickLink('Sign Up')
                ->assertPathIs('/register')
                ->assertSee('Register')
                ->click('a[href="/login"]')
                ->assertPathIs('/login')
                ->click('.logo')
                ->assertPathIs('/')
                ->assertSee('Nerdle');
        });
    }
}
