<?php

namespace App\Console\Commands;

use App\Helpers\ArticleSeeder;
use App\Services\NYTimesAPIService;

class NYTimesAPI extends BaseCommand
{
    protected $signature = 'nytimes:fetch 
                            {--query= : Search query for articles} 
                            {--begin-date= : Start date for fetching articles (YYYYMMDD)} 
                            {--end-date= : End date for fetching articles (YYYYMMDD)} 
                            {--page=0 : Page number to fetch}';

    protected $description = 'Fetch articles from the New York Times API and seed the database.';

    protected function fetchAndSeed(array $params): void
    {
        $service = app(NYTimesAPIService::class);
        $articles = $service->fetch('articlesearch.json', $params);
        // dd($articles);
        app(ArticleSeeder::class)->seed($articles, 'NYTimes');
    }
}
