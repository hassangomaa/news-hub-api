<?php

namespace Database\Factories;

use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Source>
 */
class SourceFactory extends Factory
{
    protected $model = Source::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'newsapi',
                'opennews',
                'newscred',
                'guardian',
                'nyt',
                'bbc',
                'newsapi_org',
            ]) . ' Source ' . $this->faker->unique()->numberBetween(199, 99999),
            'api_key' => $this->faker->uuid(), // Simulating API Key
            'base_url' => $this->faker->randomElement([
                'https://newsapi.org/v2/',
                'https://api.opennews.io/',
                'https://newscred.com/api/',
                'https://content.guardianapis.com/',
                'https://api.nytimes.com/svc/',
                'https://bbc.api.com/v1/',
                'https://newsapi.org/v1/',
            ]),
        ];
    }
}
