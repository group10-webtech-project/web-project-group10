<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GuestGameTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testGuestCanPlayGame()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->assertSee('Play as Guest')
                    ->clickLink('Play as Guest')
                    ->assertPathIs('/game')
                    ->assertPresent('input[data-position="0"]')
                    ->assertPresent('button[onclick="submitGuess()"]')
                    ->assertSee('Hint Store')
                    ->assertPresent('button[onclick="buyHint()"]')
                    ->assertPresent('.alert.alert-info')
                    ->assertSee('Remaining Guesses: 5');

            $browser->press('New Game')
                    ->waitFor('.alert.alert-info')
                    ->assertSee('Remaining Guesses: 5')
                    ->assertSee('Points: ');
        });
    }
}
