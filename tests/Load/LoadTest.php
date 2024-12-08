<?php

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Animal;
use App\Models\Categories;

uses(TestCase::class);

beforeEach(function () {
    DB::beginTransaction();

    $category = Categories::create([
        'name' => 'Test Category',
        'description' => 'Test Description'
    ]);

    Animal::create([
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
});

afterEach(function () {
    // Rollback any changes made during the test
    DB::rollBack();
});

test('load test game endpoint', function () {
    $startTime = microtime(true);
    $requests = 100;
    $concurrent = 10;
    $results = [];
    $retries = 3;


    $user = \App\Models\User::factory()->create();

    for ($i = 0; $i < $requests; $i += $concurrent) {
        for ($j = 0; $j < $concurrent && ($i + $j) < $requests; $j++) {
            $success = false;
            $attempts = 0;


            while (!$success && $attempts < $retries) {
                try {

                    $response = $this->actingAs($user)
                                   ->get('/game');

                    if ($response->status() === 200) {
                        $success = true;
                    }

                    $results[] = [
                        'status' => $response->status(),
                        'time' => microtime(true) - $startTime,
                        'memory' => memory_get_usage(true),
                        'attempts' => $attempts + 1
                    ];
                } catch (\Exception $e) {
                    Log::warning('Request failed', [
                        'attempt' => $attempts + 1,
                        'error' => $e->getMessage()
                    ]);
                }
                $attempts++;

                if (!$success && $attempts < $retries) {
                    usleep(100000);
                }
            }
        }
    }

    $successfulRequests = count(array_filter($results, fn($r) => $r['status'] === 200));
    $avgResponseTime = array_sum(array_column($results, 'time')) / count($results);
    $maxResponseTime = max(array_column($results, 'time'));
    $avgMemoryUsage = array_sum(array_column($results, 'memory')) / count($results);
    $totalAttempts = array_sum(array_column($results, 'attempts'));

    Log::info('Load Test Results', [
        'total_requests' => $requests,
        'successful_requests' => $successfulRequests,
        'success_rate' => ($successfulRequests / $requests) * 100 . '%',
        'average_response_time' => $avgResponseTime,
        'max_response_time' => $maxResponseTime,
        'average_memory_usage' => $avgMemoryUsage / 1024 / 1024 . 'MB',
        'total_attempts' => $totalAttempts,
        'average_attempts' => $totalAttempts / count($results)
    ]);

    expect($successfulRequests)->toBeGreaterThanOrEqual($requests * 0.95);
    expect($avgResponseTime)->toBeLessThan(1.0);
    expect($maxResponseTime)->toBeLessThan(2.0);
});

test('stress test database with concurrent game sessions', function () {
    $users = 50;
    $actionsPerUser = 20;
    $results = [];

    for ($i = 0; $i < $users; $i++) {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user)->get('/game');

        for ($j = 0; $j < $actionsPerUser; $j++) {
            $startTime = microtime(true);

            $response = $this->actingAs($user)
                           ->postJson('/game/guess', [
                               'guess' => 'TEST'
                           ]);

            $results[] = [
                'user' => $i,
                'action' => $j,
                'status' => $response->status(),
                'time' => microtime(true) - $startTime
            ];

            if ($response->json('gameOver')) {
                $this->actingAs($user)->post('/game/new');
            }
        }
    }

    $successRate = count(array_filter($results, fn($r) => $r['status'] === 200)) / count($results) * 100;
    $avgResponseTime = array_sum(array_column($results, 'time')) / count($results);

    Log::info('Stress Test Results', [
        'total_actions' => count($results),
        'success_rate' => $successRate . '%',
        'average_response_time' => $avgResponseTime
    ]);

    expect($successRate)->toBeGreaterThan(95);
    expect($avgResponseTime)->toBeLessThan(0.5);
});
