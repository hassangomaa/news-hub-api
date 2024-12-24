<?php

namespace App\Console\Commands;

use App\Services\GuardianAPIService;
use App\Helpers\ArticleSeeder;
use App\Services\CategoryService;
use App\Services\SourceService;
use Illuminate\Console\Command;

class GuardianAPI extends Command
{
    protected $signature = 'guardianapi:fetch 
                            {--section=technology : The section of articles to fetch} 
                            {--from-date=2024-01-01 : Fetch articles from this date onwards}';

    protected $description = 'Fetch data from The Guardian API and seed the database.';

    public function handle()
    {
        $section = $this->option('section');
        $fromDate = $this->option('from-date');

        try {
            $guardianAPIService = app(GuardianAPIService::class);
            $articles = $guardianAPIService->fetchArticles($section, $fromDate);

            if (!empty($articles)) {
                // Transform articles to match ArticleSeeder structure
                $formattedArticles = $this->transformArticles($articles, $section);

                $articleSeeder = app(ArticleSeeder::class);
                $articleSeeder->seed($formattedArticles, $section);

                $this->info('Articles from The Guardian have been seeded successfully.');
            } else {
                $this->warn('No articles found in the fetched data.');
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching data from The Guardian API: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Transform Guardian API articles to match seeder structure.
     *
     * @param array $articles
     * @param string $section
     * @return array
     */
    private function transformArticles(array $articles, string $section): array
    {
        return array_map(function ($article) use ($section) {
            return [
                'title' => $article['webTitle'],
                'description' => strip_tags($article['fields']['body'] ?? ''),
                'url' => $article['webUrl'],
                'published_at' => \Carbon\Carbon::parse($article['webPublicationDate'])->format('Y-m-d H:i:s'),
                'source_id' => $this->getSourceId(), // Assume The Guardian as a static source
                'author_id' => null, // No author information available in API
                'category_id' => $this->getCategoryId($section), // Map or create category based on section
            ];
        }, $articles);
    }

    /**
     * Get or create source ID for The Guardian.
     *
     * @return string
     */
    private function getSourceId(): string
    {
        $sourceService = app(SourceService::class);
        return $sourceService->createOrUpdate(['name' => 'The Guardian'])->id;
    }

    /**
     * Get or create category ID for a given section.
     *
     * @param string $section
     * @return string
     */
    private function getCategoryId(string $section): string
    {
        $categoryService = app(CategoryService::class);
        return $categoryService->createOrUpdate(['name' => ucfirst($section)])->id;
    }
}
