<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SettingsTest extends DuskTestCase
{
    use DatabaseMigrations;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);
    }

    public function test_settings_page_requires_authentication()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/settings')
                   ->assertPathIs('/login');
        });
    }

    public function test_user_can_view_settings_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                   ->visit('/settings')
                   ->assertPathIs('/settings')
                   ->assertSee('Settings')
                   ->assertSee('Original Name');
        });
    }

    public function test_user_can_update_username()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                   ->visit('/settings')
                   ->type('name', 'New Name')
                   ->press('Update Username')
                   ->waitForText('Username updated successfully')
                   ->assertSee('New Name');
        });
    }

    public function test_user_cannot_update_username_to_empty_string()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                   ->visit('/settings')
                   ->type('name', '')
                   ->press('Update Username')
                   ->waitForText('The name field is required')
                   ->assertSee('Original Name');
        });
    }

    public function test_user_can_delete_account()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                   ->visit('/settings')
                   ->click('@delete-account-button')
                   ->waitForDialog()
                   ->acceptDialog()
                   ->waitForText('Account deleted successfully')
                   ->assertPathIs('/');
        });
    }
}
