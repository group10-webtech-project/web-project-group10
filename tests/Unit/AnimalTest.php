<?php

use App\Models\Animal;
use App\Models\Categories;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->category = Categories::create([
        'name' => 'Mammals',
        'description' => 'Test category description'
    ]);

    $this->animal = Animal::create([
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
        'category_id' => $this->category->id,
        'description' => 'Test description',
        'initial_hint' => 'Test hint',
        'image_url' => 'http://example.com/image.jpg'
    ]);
});

test('animal model has correct attributes', function () {
    expect($this->animal)
        ->name->toBe('Test Animal')
        ->short_name->toBe('Test')
        ->size->toBe('Large')
        ->habitat->toBe('Forest')
        ->diet->toBe('Herbivore')
        ->region->toBe('Test Region')
        ->lifespan->toBe('10 years')
        ->has_legs->toBeTrue()
        ->has_fur->toBeTrue()
        ->can_swim->toBeFalse()
        ->can_fly->toBeFalse()
        ->is_carnivore->toBeFalse()
        ->category_id->toBe($this->category->id)
        ->description->toBe('Test description')
        ->initial_hint->toBe('Test hint')
        ->image_url->toBe('http://example.com/image.jpg');
});

test('animal belongs to a category', function () {
    expect($this->animal->category)
        ->toBeInstanceOf(Categories::class)
        ->name->toBe('Mammals');
});

test('getName returns uppercase name', function () {
    expect($this->animal->getName())->toBe('TEST ANIMAL');
});

test('getShortName returns uppercase short name', function () {
    expect($this->animal->getShortName())->toBe('TEST');
});

test('getDescription returns capitalized description', function () {
    expect($this->animal->getDescription())->toBe('Test description');
});

test('getInitialHint returns capitalized hint', function () {
    expect($this->animal->getInitialHint())->toBe('Test hint');
});

test('setDescription converts to lowercase', function () {
    $this->animal->setDescription('NEW DESCRIPTION');
    expect($this->animal->getDescription())->toBe('New description');
});

test('setDiet validates diet types', function () {
    // Valid diets should work
    expect(fn() => $this->animal->setDiet('Herbivore'))->not->toThrow(\InvalidArgumentException::class);
    expect(fn() => $this->animal->setDiet('Carnivore'))->not->toThrow(\InvalidArgumentException::class);
    expect(fn() => $this->animal->setDiet('Omnivore'))->not->toThrow(\InvalidArgumentException::class);

    // Invalid diet should throw exception
    expect(fn() => $this->animal->setDiet('Invalid'))
        ->toThrow(\InvalidArgumentException::class, 'Invalid diet type.');
});

test('getCharacteristic returns capitalized attribute value', function () {
    expect($this->animal->getCharacteristic('habitat'))->toBe('Forest');
});

test('getId returns correct id', function () {
    expect($this->animal->getId())->toBe($this->animal->id);
});

test('model uses correct table name', function () {
    expect($this->animal->getTable())->toBe('animals');
});

test('fillable attributes are correctly defined', function () {
    $fillable = [
        'name', 'short_name', 'size', 'habitat', 'diet', 'region',
        'lifespan', 'has_legs', 'has_fur', 'can_swim', 'can_fly',
        'is_carnivore',
        'category_id', 'description', 'initial_hint', 'image_url'
    ];

    expect($this->animal->getFillable())->toBe($fillable);
});
