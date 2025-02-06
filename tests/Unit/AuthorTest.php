<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    // use LazilyRefreshDatabase;

    /** @test */
    public function it_can_create_an_author()
    {
        $author = Author::factory()->create([
            'name' => 'John Doe',
        ]);

        $this->assertDatabaseHas('authors', [
            'id' => $author->id,
            'name' => 'John Doe',
        ]);
    }

    /** @test */
    public function it_generates_uuid_when_creating_an_author()
    {
        $author = Author::factory()->create();

        $this->assertNotNull($author->id);
        $this->assertTrue(strlen($author->id) === 36); // UUID should be 36 characters long
    }

    /** @test */
    public function it_can_filter_authors_by_name()
    {
        Author::factory()->create(['name' => 'Laravel Guru']);
        Author::factory()->create(['name' => 'PHP Expert']);
        Author::factory()->create(['name' => 'Vue Master']);

        $filteredAuthors = Author::where('name', 'LIKE', '%Laravel%')->get();

        $this->assertCount(1, $filteredAuthors);
        $this->assertEquals('Laravel Guru', $filteredAuthors->first()->name);
    }

    /** @test */
    public function it_can_paginate_authors()
    {
        Author::factory()->count(15)->create();

        $authors = Author::paginate(10);

        $this->assertCount(10, $authors);
        $this->assertEquals(2, $authors->lastPage()); // Should have two pages
    }

    /** @test */
    public function it_can_create_or_update_an_author()
    {
        $author = Author::updateOrCreate(
            ['name' => 'Tech Writer'],
            ['name' => 'Tech Writer']
        );

        $this->assertDatabaseHas('authors', ['name' => 'Tech Writer']);

        // Update existing author
        $updatedAuthor = Author::updateOrCreate(
            ['name' => 'Tech Writer'],
            ['name' => 'Senior Tech Writer']
        );

        $this->assertDatabaseHas('authors', ['name' => 'Senior Tech Writer']);
    }

    /** @test */
    public function an_author_can_have_multiple_articles()
    {
        $author = Author::factory()->create();
        Article::factory()->count(3)->create(['author_id' => $author->id]);

        $this->assertCount(3, $author->articles);
    }
}
