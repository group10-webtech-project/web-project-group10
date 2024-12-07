<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LandingPageTest extends DuskTestCase
{
    public function testLandingPageLoadsCorrectly()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(1000)
                ->assertSee('Nerdle')
                ->assertSee('The Ultimate Animal Guessing Game!')
                ->assertSee('Ready to test your animal knowledge?')
                ->assertVisible('.btn-primary')
                ->assertPresent('.btn-accent')
                ->assertSee('How to Play')
                ->assertSee('Why Play Nerdle?')
                ->assertSee('Player Reviews')
                ->assertSee('Share with Friends');
        });
    }
}
