<?php

namespace App\Console\Commands;

use App\Services\NewsAPIService;
use App\Helpers\ArticleSeeder;
use Illuminate\Console\Command;

class NewsAPI extends Command
{
    protected $signature = 'newsapi:test 
                            {--country=us : Country code for fetching news} 
                            {--category=technology : News category to fetch} 
                            {--source=newsapi : Source name from the configuration}';
    protected $description = 'Fetch data from the News API and seed the database.';

    public function handle()
    {
        $country = $this->option('country');
        $category = $this->option('category');
        $source = $this->option('source');

        try {
            $newsAPIService = new NewsAPIService($source);
            $data = $newsAPIService->fetchTopHeadlines($country, $category);

            if ($data['status'] === 'ok' && !empty($data['articles'])) {
                $articleSeeder = app(ArticleSeeder::class);
                $articleSeeder->seed($data['articles'], $category);
                $this->info('Articles have been seeded successfully.');
            } else {
                $this->warn('No articles found in the fetched data.');
            }
        } catch (\Exception $e) {
            \Log::error('Error: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
