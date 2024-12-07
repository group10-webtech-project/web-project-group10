<?php

use App\Models\GameSessions;
use App\Models\User;
use App\Models\Animal;
use App\Models\Categories;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $user = User::factory()->create();
    $category = Categories::create([
        'name' => 'Test Category',
        'description' => 'Test Description'
    ]);

    $animal = Animal::create([
        'name' => 'Test Animal',
        'short_name' => 'Test',
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

    $this->gameSession = GameSessions::create([
        'user_id' => $user->id,
        'animal_id' => $animal->id,
        'attempts' => 5,
        'won' => true,
        'started_at' => now(),
        'completed_at' => now()->addMinutes(10)
    ]);
});

test('game session model has correct attributes', function () {
    expect($this->gameSession)
        ->attempts->toBe(5)
        ->won->toBeTrue()
        ->started_at->toBeInstanceOf(Carbon\Carbon::class)
        ->completed_at->toBeInstanceOf(Carbon\Carbon::class);
});

test('fillable attributes are correctly defined', function () {
    $fillable = [
        'user_id',
        'animal_id',
        'attempts',
        'won',
        'started_at',
        'completed_at'
    ];

    expect($this->gameSession->getFillable())->toBe($fillable);
});

test('casts are correctly defined', function () {
    $casts = [
        'id' => 'int',
        'user_id' => 'integer',
        'animal_id' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    expect($this->gameSession->getCasts())->toBe($casts);
});

test('model uses correct table name', function () {
    expect($this->gameSession->getTable())->toBe('game_sessions');
});
