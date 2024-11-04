<?php

namespace Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase; // This trait will reset the database after each test

    public function test_category_can_be_created()
    {
        $category = \App\Models\Categories::create([
            'name' => 'Mammals',
            'description' => 'Mammals Description',
        ]);


        $this->assertDatabaseHas('categories', [
            'name' => 'Mammals',
            'description' => 'Mammals Description',
        ]);
    }
}
