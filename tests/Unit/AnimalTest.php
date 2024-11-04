<?php

namespace Tests\Unit;

use App\Models\Animal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimalTest extends TestCase
{
    use RefreshDatabase; // This trait will reset the database after each test

    public function test_animal_can_be_created()
    {
        // Create a category first
        $category = \App\Models\Categories::create([
            'name' => 'Mammals'
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

        $this->assertDatabaseHas('animals', [
            'name' => 'Lion',
            'diet' => 'Carnivore',
        ]);
    }

    public function test_get_description()
    {
        $animal = new Animal();
        $animal->setDescription('the king of the jungle');

        $this->assertEquals('The king of the jungle', $animal->getDescription());
    }

    public function test_set_diet_with_valid_value()
    {
        $animal = new Animal();
        $animal->setDiet('Herbivore');

        $this->assertEquals('Herbivore', $animal->diet);
    }

    public function test_set_diet_with_invalid_value()
    {
        $this->expectException(\InvalidArgumentException::class);
        $animal = new Animal();
        $animal->setDiet('InvalidDiet');
    }

    public function test_animal_belongs_to_category()
    {
        // Assuming you have a Category model and a categories table
        $category = \App\Models\Categories::create(['name' => 'Mammals']);
        $animal = Animal::create([
            'name' => 'Elephant',
            'size' => 'Large',
            'habitat' => 'Savannah',
            'diet' => 'Herbivore',
            'region' => 'Africa',
            'lifespan' => '60-70 years',
            'category_id' => $category->id,
        ]);

        $this->assertInstanceOf(\App\Models\Categories::class, $animal->category);
        $this->assertEquals($category->id, $animal->category->id);
    }
}
