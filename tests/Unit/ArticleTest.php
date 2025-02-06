<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;
    // use LazilyRefreshDatabase;//only refreshes the database when needed

    /** @test */
    public function it_can_create_an_article()
    {

        $article = Article::factory()->create();
        // dd($article);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => $article->title,
            'url' => $article->url,
        ]);
    }

    /** @test */
    public function it_generates_uuid_when_creating_an_article()
    {
        $article = Article::factory()->create();

        $this->assertNotNull($article->id);
        $this->assertTrue(strlen($article->id) === 36); // UUID should be 36 characters long
    }

    /** @test */
    public function it_belongs_to_a_source()
    {

        $article = Article::factory()->create();

        $this->assertInstanceOf(Source::class, $article->source);
    }

    /** @test */
    public function it_belongs_to_an_author()
    {

        $article = Article::factory()->create();

        $this->assertInstanceOf(Author::class, $article->author);
    }

    /** @test */
    public function it_belongs_to_a_category()
    {

        $article = Article::factory()->create();

        $this->assertInstanceOf(Category::class, $article->category);
    }

    /** @test */
    public function it_can_filter_articles_by_title()
    {

        Article::factory()->create(['title' => 'Laravel Testing Guide']);
        Article::factory()->create(['title' => 'PHP Best Practices']);

        $foundArticles = Article::where('title', 'LIKE', '%Laravel%')->get();

        $this->assertCount(1, $foundArticles);
        $this->assertEquals('Laravel Testing Guide', $foundArticles->first()->title);
    }

    /** @test */
    public function it_can_filter_articles_by_category()
    {

        $category = Category::factory()->create();

        Article::factory()->count(2)->create(['category_id' => $category->id]);
        Article::factory()->count(3)->create(); // Other random articles

        $filteredArticles = Article::where('category_id', $category->id)->get();

        $this->assertCount(2, $filteredArticles);
    }
}
