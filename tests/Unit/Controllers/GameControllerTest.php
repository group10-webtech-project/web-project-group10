<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\GameController;
use App\Models\Animal;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    use RefreshDatabase;

    private GameController $gameController;
    private Animal $animal;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $category = Categories::create([
            'name' => 'Test Category',
            'description' => 'Test Description'
        ]);

        $this->animal = Animal::create([
            'name' => 'Test Animal',
            'short_name' => 'TEST',
            'size' => 'Large',
            'habitat' => 'Forest',
            'diet' => 'Herbivore',
            'region' => 'Test Region',
            'lifespan' => '10 years',
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => false,
            'can_fly' => false,
            'is_carnivore' => false,
            'category_id' => $category->id,
            'description' => 'Test description',
            'initial_hint' => 'Test hint',
            'image_url' => 'test.jpg'
        ]);

        $this->gameController = new GameController();
    }

    public function test_index_creates_new_game_for_guest()
    {
        // Initialize a new game session first
        session([
            'animal' => 'TEST',
            'points' => 1000
        ]);

        $response = $this->get('/game');

        $response->assertSuccessful();
        $this->assertNotNull(session('guest_name'));
        $this->assertNotNull(session('points'));
    }

    public function test_index_creates_new_game_for_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Initialize a new game session first
        session([
            'animal' => 'TEST',
            'points' => 1000
        ]);

        $response = $this->get('/game');

        $response->assertSuccessful();
        $this->assertNull(session('guest_name'));
        $this->assertNotNull(session('points'));
    }

    public function test_guess_validates_input()
    {
        $response = $this->postJson('/game/guess', [
            'guess' => ''
        ]);

        $response->assertStatus(422);
    }

    public function test_correct_guess_ends_game()
    {
        session([
            'animal' => 'TEST',
            'points' => 1000,
            'gameOver' => false
        ]);

        $response = $this->postJson('/game/guess', [
            'guess' => 'TEST'
        ]);

        $response->assertSuccessful();
        $this->assertTrue(session('gameOver'));
        $this->assertTrue(session('won'));
        $this->assertGreaterThan(1000, session('points'));
    }

    public function test_buy_hint_deducts_points()
    {
        session([
            'animal' => 'TEST',
            'points' => 1000,
            'hints' => []
        ]);

        $response = $this->postJson('/game/hint');

        $response->assertSuccessful();
        $this->assertLessThan(1000, session('points'));
        $this->assertNotEmpty(session('hints'));
    }



    public function test_new_game_resets_session()
    {
        session([
            'animal' => 'OLD',
            'points' => 0,
            'gameOver' => true,
            'won' => true
        ]);

        $response = $this->post('/game/new');

        $response->assertRedirect('/game');
        $this->assertNotEquals('OLD', session('animal'));
        $this->assertFalse(session('gameOver'));
        $this->assertFalse(session('won'));
    }

    public function test_catalogue_returns_view()
    {
        $response = $this->get('/catalogue');

        $response->assertSuccessful();
        $response->assertViewIs('catalogue');
        $response->assertViewHas('animals');
    }

    public function test_set_theme()
    {
        $response = $this->postJson('/game/set-theme', [
            'theme' => 'dark'
        ]);

        $response->assertSuccessful();
        $this->assertEquals('dark', session('theme'));
    }
}
