<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create an admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'jamus23@student.sdu.dk',
            'password' => Hash::make('UYFcm00HWLF7dw'),
            'role' => 'admin'
        ]);

        $this->call([
            AnimalCategorySeeder::class,  // Run categories first since animals depend on them
            AnimalsSeeder::class,
            GameDataSeeder::class
        ]);
    }
}
