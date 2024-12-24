<?php

namespace App\Helpers;

use App\Services\ArticleService;
use App\Services\AuthorService;
use App\Services\CategoryService;
use App\Services\SourceService;

class ArticleSeeder
{
    protected $batchSize = 100;

    public function seed(array $articles, string $category)
    {
        $sourcesData = [];
        $authorsData = [];
        $categoriesData = [];
        $articlesData = [];

        foreach ($articles as $index => $articleData) {
            try {
                // Extract and normalize data
                $sourceName = strtolower($articleData['source']['name'] ?? 'unknown');
                $authorName = strtolower($articleData['author'] ?? 'unknown');
                $publishedAt = isset($articleData['publishedAt'])
                    ? \Carbon\Carbon::parse($articleData['publishedAt'])->format('Y-m-d H:i:s')
                    : now();

                // Handle source
                if (!isset($sourcesData[$sourceName])) {
                    $source = app(SourceService::class)->createOrUpdate(['name' => $sourceName]);
                    $sourcesData[$sourceName] = $source->id;
                }

                // Handle author
                if (!isset($authorsData[$authorName])) {
                    $author = app(AuthorService::class)->createOrUpdate(['name' => $authorName]);
                    $authorsData[$authorName] = $author->id;
                }

                // Handle category
                if (!isset($categoriesData[$category])) {
                    $categoryEntity = app(CategoryService::class)->createOrUpdate(['name' => $category]);
                    $categoriesData[$category] = $categoryEntity->id;
                }

                // Prepare article data
                $articleInput = [
                    'title' => $articleData['title'],
                    'description' => $articleData['description'],
                    'url' => $articleData['url'],
                    'published_at' => $publishedAt,
                    'source_id' => $sourcesData[$sourceName],
                    'author_id' => $authorsData[$authorName],
                    'category_id' => $categoriesData[$category],
                ];

                $articlesData[] = $articleInput;

                // Process batch if size reached
                if (($index + 1) % $this->batchSize === 0) {
                    $this->processBatch($articlesData);
                }
            } catch (\Exception $e) {
                \Log::error("Error processing article data: {$e->getMessage()}", ['articleData' => $articleData]);
                continue;
            }
        }

        // Process remaining data
        if (!empty($articlesData)) {
            $this->processBatch($articlesData);
        }
    }

    protected function processBatch(array &$articlesData)
    {
        try {
            app(ArticleService::class)->createManyArticles($articlesData);
            \Log::info("Batch processed successfully with " . count($articlesData) . " articles.");
        } catch (\Exception $e) {
            \Log::error("Error processing batch: {$e->getMessage()}");
        } finally {
            $articlesData = [];
        }
    }
}
