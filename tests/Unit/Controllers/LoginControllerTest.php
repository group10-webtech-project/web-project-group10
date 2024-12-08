<?php

namespace Tests\Unit\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);
    }

    public function test_show_login_form()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('login');
    }

    public function test_login_with_valid_credentials()
    {
        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertRedirect(route('game.index'));
        $this->assertAuthenticated();
    }

    public function test_login_with_invalid_credentials()
    {
        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'wrong-password'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_logout()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('landing'));
        $this->assertGuest();
    }

    public function test_remember_me_functionality()
    {
        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password',
            'remember' => 'on'
        ]);

        $response->assertRedirect(route('game.index'));
        $this->assertAuthenticated();
        $this->assertNotNull($this->user->fresh()->remember_token);
    }
}
