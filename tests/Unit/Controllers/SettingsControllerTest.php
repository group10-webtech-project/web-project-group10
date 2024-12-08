<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'test@example.com'
        ]);
    }

    public function test_show_settings_requires_authentication()
    {
        $response = $this->get('/settings');
        $response->assertRedirect('/login');
    }

    public function test_show_settings_for_authenticated_user()
    {
        $this->actingAs($this->user);
        $response = $this->get('/settings');
        $response->assertSuccessful();
        $response->assertViewIs('settings');
    }

    public function test_update_username_requires_authentication()
    {
        $response = $this->postJson('/settings/username', [
            'name' => 'New Name'
        ]);

        $response->assertStatus(401);
    }

    public function test_update_username_validates_required_fields()
    {
        $this->actingAs($this->user);
        $response = $this->postJson('/settings/username', []);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function test_update_username_successfully()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/settings/username', [
            'name' => 'New Name'
        ]);

        $response->assertSuccessful();
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'New Name'
        ]);
    }

    public function test_delete_account_requires_authentication_web()
    {
        $response = $this->delete('/settings/delete-account');
        $response->assertRedirect('/login');
    }

    public function test_delete_account_requires_authentication_api()
    {
        $response = $this->deleteJson('/settings/delete-account');
        $response->assertStatus(401);
    }

    public function test_delete_account_successfully()
    {
        $this->actingAs($this->user);

        $response = $this->deleteJson('/settings/delete-account');

        $response->assertSuccessful();
        $response->assertJson(['success' => true]);

        $this->assertDatabaseMissing('users', [
            'id' => $this->user->id
        ]);

        $this->assertGuest();
    }

    public function test_update_username_max_length()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/settings/username', [
            'name' => str_repeat('a', 256)
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function test_update_username_same_name()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/settings/username', [
            'name' => 'Original Name'
        ]);

        $response->assertSuccessful();
        $response->assertJson(['success' => true]);
    }

    public function test_update_username_rejects_empty_string()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/settings/username', [
            'name' => ''
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Original Name'
        ]);
    }
}
