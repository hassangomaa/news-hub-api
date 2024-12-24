<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            [
                'name' => 'newsapi',
                'api_key' => env('NEWSAPI_API_KEY'),
                'base_url' => 'https://newsapi.org/v2/',
            ],
            [
                'name' => 'opennews',
                'api_key' => env('OPENNEWS_API_KEY'),
                'base_url' => 'https://api.opennews.io/',
            ],
            [
                'name' => 'newscred',
                'api_key' => env('NEWSCRED_API_KEY'),
                'base_url' => 'https://newscred.com/api/',
            ],
            [
                'name' => 'guardian',
                'api_key' => env('GUARDIAN_API_KEY'),
                'base_url' => 'https://content.guardianapis.com/',
            ],
            [
                'name' => 'nyt',
                'api_key' => env('NYT_API_KEY'),
                'base_url' => 'https://api.nytimes.com/svc/',
            ],
            [
                'name' => 'bbc',
                'api_key' => env('BBC_API_KEY'),
                'base_url' => 'https://bbc.api.com/v1/',
            ],
            [
                'name' => 'newsapi_org',
                'api_key' => env('NEWSAPI_ORG_API_KEY'),
                'base_url' => 'https://newsapi.org/v1/',
            ],
        ];

        foreach ($sources as $source) {
            Source::updateOrCreate(
                ['name' => $source['name']], 
                [
                    'api_key' => $source['api_key'],
                    'base_url' => $source['base_url']
                ]
            );
        }
    }
}