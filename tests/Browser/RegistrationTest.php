<?php

namespace Tests\Browser;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testUserRegistration()
    {
        $this->browse(function (Browser $browser) {
            // Generate unique email using timestamp
            $timestamp = time();
            $testEmail = "test{$timestamp}@example.com";
            $testPassword = 'password123';
            $testUsername = "testuser{$timestamp}";

            // Step 1: Register new account
            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->clickLink('Create New Account')
                    ->assertPathIs('/register')
                    ->assertSee('Create Account')
                    ->type('name', $testUsername)
                    ->type('email', $testEmail)
                    ->type('password', $testPassword)
                    ->type('password_confirmation', $testPassword)
                    ->press('Register')
                    ->pause(3000) // Wait for AJAX and redirect
                    ->waitForLocation('/game')
                    ->assertPathIs('/game')
                    ->assertSee($testUsername);
        });
    }
}
