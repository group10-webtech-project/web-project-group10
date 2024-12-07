<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ThemeSwitchingTest extends DuskTestCase
{
    public function testThemeSwitching()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(1000)
                ->assertSee('Nerdle');

            $browser->waitFor('.theme-controller', 5)
                ->click('.theme-controller')
                ->pause(1000)
                ->assertAttribute('html', 'data-theme', 'dark');

            $browser->waitFor('.theme-controller', 5)
                ->click('.theme-controller')
                ->pause(1000)
                ->assertAttribute('html', 'data-theme', 'light');
        });
    }
}
