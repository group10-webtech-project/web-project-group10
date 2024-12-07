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
                ->clickLink('Login')
                ->pause(1000)
                ->assertPathIs('/login')
                ->assertSee('Welcome Back!')
                ->clickLink('Forgot password?')
                ->assertPathIs('/forgot-password')
                ->assertSee('Reset Password')
                ->clickLink('Back to Login')
                ->assertPathIs('/login')
                ->assertSee('Welcome Back!')
                ->clickLink('Nerdle')
                ->assertPathIs('/');
        });
    }
}
