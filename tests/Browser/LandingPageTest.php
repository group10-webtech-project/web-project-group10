<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LandingPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testLandingPageResponsiveness()
    {
        $this->browse(function (Browser $browser) {
            // Test desktop view (1920x1080)
            $browser->resize(1920, 1080)
                    ->visit('/')
                    // Hero Section
                    ->assertPresent('.card.glass.shadow-2xl')
                    ->assertSee('Nerdle')
                    ->assertSee('The Ultimate Animal Guessing Game!');

            // Test tablet view (768x1024)
            $browser->resize(768, 1024)
                    ->refresh()
                    ->assertPresent('.grid.md\\:grid-cols-3')
                    ->assertPresent('.card.bg-base-100.shadow-xl')
                    ->assertSee('How to Play')
                    ->assertSee('Why Play Nerdle?')
                    ->assertSee('Player Reviews');

            // Test mobile view (375x812)
            $browser->resize(375, 812)
                    ->refresh()
                    ->assertPresent('.sm\\:hidden')
                    ->assertMissing('.hidden.sm\\:inline');
        });
    }

    public function testLandingPageFeatures()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Start a game')
                    ->assertSee('Use hints wisely')
                    ->assertSee('Make smart guesses')

                    ->assertPresent('.badge.badge-lg')
                    ->assertSee('🤓')
                    ->assertSee('You are a NERD!')
                    ->assertSee('🧠')
                    ->assertSee('Train Your Brain')
                    ->assertSee('🏆')
                    ->assertSee('Compete with Friends')

                    ->assertSee('So much fun! Perfect for animal lovers!')
                    ->assertSee('Educational and entertaining for the whole family!')
                    ->assertSee('I cannot stop playing this game! How is this a webtech project?!!');
        });
    }

    public function testLandingPageAnimations()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPresent('.animate-fade-in')
                    ->assertPresent('.animate-fade-in-delay-1')
                    ->assertPresent('.animate-bounce-in')
                    ->assertPresent('.hover\\:shadow-2xl')
                    ->assertPresent('.hover\\:scale-105')
                    ->assertPresent('.transition-transform')
                    ->assertPresent('.hover\\:-translate-y-2');
        });
    }

    public function testNavigationLinks()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->back()
                    ->clickLink('Play as Guest')
                    ->assertPathIs('/game')
                    ->back();
        });
    }
}
