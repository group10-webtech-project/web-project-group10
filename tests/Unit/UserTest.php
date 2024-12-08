<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'username' => 'testuser',
        'password' => bcrypt('password')
    ]);
});

test('user model has correct attributes', function () {
    expect($this->user)
        ->name->toBe('Test User')
        ->email->toBe('test@example.com')
        ->username->toBe('testuser');
});

test('fillable attributes are correctly defined', function () {
    $fillable = [
        'username',
        'name',
        'email',
        'password',
    ];

    expect($this->user->getFillable())->toBe($fillable);
});

test('hidden attributes are correctly defined', function () {
    $hidden = [
        'password',
        'last_login',
        'remember_token',
    ];

    expect($this->user->getHidden())->toBe($hidden);
});

test('casts are correctly defined', function () {
    $casts = [
        'id' => 'int',
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'password' => 'hashed',
    ];

    expect($this->user->getCasts())->toBe($casts);
});

test('user factory creates valid user', function () {
    $user = User::factory()->create();

    expect($user)
        ->toBeInstanceOf(User::class)
        ->name->not->toBeEmpty()
        ->email->not->toBeEmpty()
        ->password->not->toBeEmpty();
});
