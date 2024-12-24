<?php

namespace App\Console\Commands;

use App\Services\NYTimesAPIService;
use App\Helpers\ArticleSeeder;
use Illuminate\Console\Command;

class NYTimesAPI extends Command
{
    protected $signature = 'nytimes:fetch 
                            {--query= : Search query for articles} 
                            {--begin-date= : Start date for fetching articles (YYYYMMDD)} 
                            {--end-date= : End date for fetching articles (YYYYMMDD)} 
                            {--page=0 : Page number to fetch}';

    protected $description = 'Fetch articles from the New York Times API and seed the database.';

    public function handle()
    {
        $query = $this->option('query');
        $beginDate = $this->option('begin-date');
        $endDate = $this->option('end-date');
        $page = (int) $this->option('page');

        try {
            $nyTimesAPIService = app(NYTimesAPIService::class);
            $articles = $nyTimesAPIService->fetchArticles($query, $beginDate, $endDate, $page);

            if (!empty($articles)) {
                // Map NY Times data to standard structure
                $mappedArticles = $this->mapNYTimesToStandard($articles);

                // Seed articles using ArticleSeeder
                $articleSeeder = app(ArticleSeeder::class);
                $articleSeeder->seed($mappedArticles, 'New York Times');

                $this->info('Articles from the New York Times have been seeded successfully.');
            } else {
                $this->warn('No articles found in the fetched data.');
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching data from the New York Times API: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Map NY Times API response to a standard structure for seeder.
     *
     * @param array $articles
     * @return array
     */
    private function mapNYTimesToStandard(array $articles): array
    {
        return array_map(function ($article) {
            return [
                'title' => $article['headline']['main'] ?? 'Unknown Title',
                'description' => $article['headline']['kicker'] ?? '',
                'url' => $article['web_url'] ?? '',
                'publishedAt' => isset($article['pub_date']) ? \Carbon\Carbon::parse($article['pub_date'])->format('Y-m-d H:i:s') : now(),
                'source' => $article['source'] ?? 'Unknown',
                'author' => 'Unknown', // NY Times API doesn't provide author directly
                'category' => $article['section_name'] ?? 'General',
            ];
        }, $articles);
    }
}
