<?php

namespace Tests\Unit;

use App\Models\Animal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameSessionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_game_session_can_be_created()
    {
        $user = \App\Models\User::create([
            'username' => 'test',
            'name' => 'test',
            'email' => 'test@test.com',
            'password'=> '12345678',
        ]);

        $category = \App\Models\Categories::create([
            'name' => 'Mammals',
            'description' => 'Mammals Description',
        ]);
        $animal = Animal::create([
            'name' => 'Lion',
            'size' => 'Large',
            'habitat' => 'Savannah',
            'diet' => 'Carnivore',
            'region' => 'Africa',
            'lifespan' => '10-14 years',
            'category_id' => $category->id,  // Use the created category's ID
            'description' => 'The king of the jungle',
            'image_url' => 'http://example.com/lion.jpg',
        ]);

        $date = now();

        // Create a category first
        $gameSession = \App\Models\GameSessions::create([
            'user_id' => $user->id,
            'animal_id' => $animal->id,
            'attempts' => 5,
            'won' => true,
            'started_at' => $date,
            'completed_at' => $date,
        ]);


        $this->assertDatabaseHas('game_sessions', [
            'attempts' => 5,
            'won' => true,
            'started_at' => $date,
        ]);
    }
}
