<?php


namespace App\Console\Commands;

use App\Services\NYTimesAPIService;
use App\Helpers\ArticleSeeder;

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
        try {
            $service = app(NYTimesAPIService::class);
            $rawArticles = $service->fetch('articlesearch.json', $params);

            if (empty($rawArticles)) {
                $this->warn('No articles found in the fetched data.');
                return;
            }

            // Map raw articles to standard structure
            $mappedArticles = $this->mapNYTimesToStandard($rawArticles);

            // Seed articles using ArticleSeeder
            app(ArticleSeeder::class)->seed($mappedArticles, 'NYTimes');

            $this->info('Articles from the New York Times have been seeded successfully.');
        } catch (\Exception $e) {
            \Log::error("Error fetching data from NYTimes API: {$e->getMessage()}");
            $this->error("Error: {$e->getMessage()}");
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
                'published_at' => $article['pub_date'] ?? '',
                'source' => $article['source'] ?? 'NYTimes',
                'author' => $article['byline']['original'] ?? null,
                'category' => $article['section_name'] ?? 'General',
            ];
        }, $articles['response']['docs'] ?? []);
    }

    /**
     * Process command options into API request parameters.
     *
     * @return array
     */
    protected function getParams(): array
    {
        return [
            'q' => $this->option('query'),
            'begin_date' => $this->option('begin-date'),
            'end_date' => $this->option('end-date'),
            'page' => (int) $this->option('page'),
        ];
    }

    public function handle()
    {
        $params = $this->getParams();
        $this->fetchAndSeed($params);
    }
}
