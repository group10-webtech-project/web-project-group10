<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PopulateGameData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First, create users
        $users = [
            [
                'name' => 'John Smith',
                'email' => 'john@example.com',
                'username' => 'john_smith',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'last_login' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah@example.com',
                'username' => 'sarah_w',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'last_login' => now()->subHours(2),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subHours(2),
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'username' => 'mike_j',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'last_login' => now()->subDays(1),
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(1),
            ],
        ];

        // Insert users and get their IDs
        $userIds = [];
        foreach ($users as $userData) {
            $userId = DB::table('users')->insertGetId($userData);
            $userIds[] = $userId;
        }

        // Get some random animal IDs
        $animalIds = DB::table('animals')->inRandomOrder()->limit(3)->pluck('id')->toArray();

        // Create game sessions
        $gameSessions = [
            [
                'user_id' => $userIds[0],
                'animal_id' => $animalIds[0],
                'attempts' => 4,
                'won' => true,
                'started_at' => now()->subHours(1),
                'completed_at' => now()->subMinutes(45),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[1],
                'animal_id' => $animalIds[1],
                'attempts' => 6,
                'won' => true,
                'started_at' => now()->subHours(3),
                'completed_at' => now()->subHours(2),
                'created_at' => now()->subHours(3),
                'updated_at' => now()->subHours(2),
            ],
            [
                'user_id' => $userIds[2],
                'animal_id' => $animalIds[2],
                'attempts' => 8,
                'won' => false,
                'started_at' => now()->subDays(1),
                'completed_at' => now()->subDays(1)->addHours(1),
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1)->addHours(1),
            ],
        ];

        DB::table('game_sessions')->insert($gameSessions);

        // Create leaderboard entries
        $leaderboard = [
            [
                'user_id' => $userIds[0],
                'total_games' => 10,
                'total_wins' => 8,
                'avg_attempts' => 4.5,
                'current_streak' => 3,
                'best_streak' => 5,
                'points' => 800,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[1],
                'total_games' => 15,
                'total_wins' => 12,
                'avg_attempts' => 5.2,
                'current_streak' => 4,
                'best_streak' => 6,
                'points' => 1200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[2],
                'total_games' => 8,
                'total_wins' => 5,
                'avg_attempts' => 6.1,
                'current_streak' => 0,
                'best_streak' => 3,
                'points' => 500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('leaderboard')->insert($leaderboard);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('leaderboard')->truncate();
        DB::table('game_sessions')->truncate();
        DB::table('users')->truncate();
    }
}
