<?php

namespace Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaderboardTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_leaderboard_can_be_created(): void
    {
        $user = \App\Models\User::create([
            'username' => 'test',
            'name' => 'test',
            'email' => 'test@test.com',
            'password'=> '12345678',
        ]);

        $leaderboard = \App\Models\Leaderboard::create([
            'user_id' => $user->id,
            'total_games'=> 5,
            'total_wins'=> 5,
            'avg_attempts'=> 2.51,
            'current_streak'=> 0,
            'best_streak' => 100
        ]);

        $this->assertDatabaseHas('leaderboard', [
            'user_id' => $user->id,
            'total_games' => 5,
            'avg_attempts'=> 2.51,
            'current_streak'=> 0,
        ]);
    }
}
