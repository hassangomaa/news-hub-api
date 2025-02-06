<?php

namespace App\Console\Commands;

use App\Helpers\ArticleSeeder;
use App\Services\GuardianAPIService;

class GuardianAPI extends BaseCommand
{
    protected $signature = 'guardianapi:fetch 
                            {--section=technology : The section of articles to fetch} 
                            {--from-date=2024-01-01 : Fetch articles from this date onwards}';

    protected $description = 'Fetch data from The Guardian API and seed the database.';

    protected function fetchAndSeed(array $params): void
    {
        $service = app(GuardianAPIService::class);
        $articles = $service->fetch('search', [
            'section' => $params['section'],
            'from-date' => $params['from-date'],
        ]);
        app(ArticleSeeder::class)->seed($articles, $params['section']);
    }
}
