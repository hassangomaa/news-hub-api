<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_category()
    {
        $category = Category::factory()->create([
            'name' => 'Technology',
        ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Technology',
        ]);
    }

    /** @test */
    public function it_generates_uuid_when_creating_a_category()
    {
        $category = Category::factory()->create();

        $this->assertNotNull($category->id);
        $this->assertTrue(strlen($category->id) === 36); // UUID should be 36 characters long
    }

    /** @test */
    public function it_can_filter_categories_by_name()
    {
        Category::factory()->create(['name' => 'Tech']);
        Category::factory()->create(['name' => 'Business']);
        Category::factory()->create(['name' => 'Health']);

        $filteredCategories = Category::where('name', 'LIKE', '%Tech%')->get();

        $this->assertCount(1, $filteredCategories);
        $this->assertEquals('Tech', $filteredCategories->first()->name);
    }

    /** @test */
    public function it_can_paginate_categories()
    {
        Category::factory()->count(15)->create();

        $categories = Category::paginate(10);

        $this->assertCount(10, $categories);
        $this->assertEquals(2, $categories->lastPage()); // Should have two pages
    }

    /** @test */
    public function it_can_create_or_update_a_category()
    {
        $category = Category::updateOrCreate(
            ['name' => 'Science'],
            ['name' => 'Science']
        );

        $this->assertDatabaseHas('categories', ['name' => 'Science']);

        // Update existing category
        $updatedCategory = Category::updateOrCreate(
            ['name' => 'Science'],
            ['name' => 'Applied Science']
        );

        $this->assertDatabaseHas('categories', ['name' => 'Applied Science']);
    }

    /** @test */
    public function a_category_can_have_multiple_articles()
    {
        $category = Category::factory()->create();
        Article::factory()->count(3)->create(['category_id' => $category->id]);

        $this->assertCount(3, $category->articles);
    }
}
