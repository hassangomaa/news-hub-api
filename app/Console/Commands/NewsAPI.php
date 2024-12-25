<?php

namespace App\Console\Commands;

use App\Services\NewsAPIService;
use App\Helpers\ArticleSeeder;

class NewsAPI extends BaseCommand
{
    protected $signature = 'newsapi:test 
                            {--country=us : Country code for fetching news} 
                            {--category=technology : News category to fetch} 
                            {--source=newsapi : Source name from the configuration}';
    protected $description = 'Fetch data from the News API and seed the database.';

    protected function fetchAndSeed(array $params): void
    {
        $service = app(NewsAPIService::class);
        $articles = $service->fetch('top-headlines', [
            'country' => $params['country'],
            'category' => $params['category'],
        ]);
        app(ArticleSeeder::class)->seed($articles, $params['category']);
    }
}
