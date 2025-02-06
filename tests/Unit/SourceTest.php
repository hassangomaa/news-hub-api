<?php

namespace Tests\Unit;

use App\Models\Source;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_source()
    {
        $source = Source::factory()->create([
            'name' => 'NewsAPI',
            'api_key' => 'sample_api_key',
            'base_url' => 'https://newsapi.org/v2/',
        ]);

        $this->assertDatabaseHas('sources', [
            'id' => $source->id,
            'name' => 'NewsAPI',
        ]);
    }

    /** @test */
    public function it_generates_uuid_when_creating_a_source()
    {
        $source = Source::factory()->create();

        $this->assertNotNull($source->id);
        $this->assertTrue(strlen($source->id) === 36); // UUID should be 36 characters long
    }

    /** @test */
    public function it_can_filter_sources_by_name()
    {
        Source::factory()->create(['name' => 'NewsAPI']);
        Source::factory()->create(['name' => 'OpenNews']);
        Source::factory()->create(['name' => 'GuardianAPI']);

        $filteredSources = Source::where('name', 'LIKE', '%News%')->get();

        $this->assertCount(2, $filteredSources);
    }

    /** @test */
    public function it_can_paginate_sources()
    {
        // dd(Source::all());

        Source::factory()->count(15)->create();

        //dd all sources

        $sources = Source::paginate(10);
        // dd($sources);

        $this->assertCount(10, $sources);
        $this->assertEquals(2, $sources->lastPage()); // Should have two pages
    }

    /** @test */
    public function it_can_create_or_update_a_source()
    {
        $source = Source::updateOrCreate(
            ['name' => 'TechNews'],
            ['api_key' => 'technews_key', 'base_url' => 'https://technews.com/api/']
        );

        $this->assertDatabaseHas('sources', ['name' => 'TechNews']);

        // Update existing source
        $updatedSource = Source::updateOrCreate(
            ['name' => 'TechNews'],
            ['api_key' => 'updated_technews_key']
        );

        $this->assertDatabaseHas('sources', ['api_key' => 'updated_technews_key']);
    }

    /** @test */
    public function a_source_can_have_multiple_articles()
    {
        $source = Source::factory()->create();
        Article::factory()->count(3)->create(['source_id' => $source->id]);

        $this->assertCount(3, $source->articles);
    }
}
