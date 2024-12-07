<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LandingPageTest extends DuskTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLandingPageLoadsCorrectly()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(1000) // Wait for 1 second for the page to load
                ->assertSee('Nerdle') // Check if the title is present
                ->assertSee('The Ultimate Animal Guessing Game!') // Check subtitle
                ->assertSee('Ready to test your animal knowledge?') // Check description
                ->assertVisible('.btn-primary') // Check if the Login button is visible
                ->assertPresent('.btn-accent') // Check if the Play as Guest button is present
                ->assertSee('How to Play') // Check if the How to Play section is present
                ->assertSee('Why Play Nerdle?') // Check if the Why Play section is present
                ->assertSee('Player Reviews') // Check if the Player Reviews section is present
                ->assertSee('Share with Friends'); // Check if the Share section is present
        });
    }
}
