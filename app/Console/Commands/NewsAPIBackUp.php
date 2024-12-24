<?php

// namespace App\Console\Commands;


// use App\Services\NewsAPIService;
// use App\Services\ArticleService;
// use App\Services\AuthorService;
// use App\Services\CategoryService;
// use App\Services\SourceService;
// use Illuminate\Console\Command;

// class NewsAPIBackUp extends Command
// {
//     protected $signature = 'newsapi:test 
//                             {--country=us : Country code for fetching news} 
//                             {--category=technology : News category to fetch} 
//                             {--source=newsapi : Source name from the configuration}';
//     protected $description = 'Fetch data from the News API and seed the database.';

//     public function handle()
//     {
//         $country = $this->option('country');
//         $category = $this->option('category');
//         $source = $this->option('source');

//         try {
//             $newsAPIService = new NewsAPIService($source);
//             $data = $newsAPIService->fetchTopHeadlines($country, $category);

//             if ($data['status'] === 'ok' && !empty($data['articles'])) {
//                 $this->seedArticles($data['articles']);
//                 $this->info('Articles have been seeded successfully.');
//             } else {
//                 $this->warn('No articles found in the fetched data.');
//             }
//         } catch (\Exception $e) {
//             $this->error('Error: ' . $e->getMessage());
//         }
//     }
 

//     protected function seedArticles(array $articles)
//     {

//         try {
//             $sourcesData = [];
//             $authorsData = [];
//             $categoriesData = [];
//             $articlesData = [];
//             $batchSize = 100; // Define the batch size for bulk insertion

//             foreach ($articles as $index => $articleData) {
//                 try {
//                     // Normalize and extract data
//                     $sourceName = strtolower($articleData['source']['name'] ?? 'unknown');
//                     $authorName = strtolower($articleData['author'] ?? 'unknown');
//                     $categoryName = strtolower($this->option('category'));
//                     $publishedAt = isset($articleData['publishedAt'])
//                         ? \Carbon\Carbon::parse($articleData['publishedAt'])->format('Y-m-d H:i:s')
//                         : now();

//                     // Handle source creation or update
//                     if (!isset($sourcesData[$sourceName])) {
//                         $source = app(SourceService::class)->createOrUpdate(['name' => $sourceName]);
//                         $sourcesData[$sourceName] = $source->id;
//                     }

//                     // Handle author creation or update
//                     if (!isset($authorsData[$authorName])) {
//                         $author = app(AuthorService::class)->createOrUpdate(['name' => $authorName]);
//                         $authorsData[$authorName] = $author->id;
//                     }

//                     // Handle category creation or update
//                     if (!isset($categoriesData[$categoryName])) {
//                         $category = app(CategoryService::class)->createOrUpdate(['name' => $categoryName]);
//                         $categoriesData[$categoryName] = $category->id;
//                     }

//                     // Prepare article data
//                     $articleInput = [
//                         'title' => $articleData['title'],
//                         'description' => $articleData['description'],
//                         'url' => $articleData['url'],
//                         'published_at' => $publishedAt,
//                         'source_id' => $sourcesData[$sourceName],
//                         'author_id' => $authorsData[$authorName],
//                         'category_id' => $categoriesData[$categoryName],
//                     ];

//                     $articlesData[] = $articleInput;

//                     // Process batch if the batch size is reached
//                     if (($index + 1) % $batchSize === 0) {
//                         $this->processBatch($articlesData);
//                     }
//                 } catch (\Exception $e) {
//                     \Log::error("Error processing article data: {$e->getMessage()}", [
//                         'articleData' => $articleData,
//                     ]);
//                     continue;
//                 }
//             }

//             // Process remaining data after loop
//             if (!empty($articlesData)) {
//                 $this->processBatch($articlesData);
//             }
//         } catch (\Exception $e) {
//             \Log::error("Critical error during seeding: {$e->getMessage()}");
//         }
//     }

//     /**
//      * Process a batch of articles for insertion.
//      */
//     protected function processBatch(array &$articlesData)
//     {
//         try {
//             // dd($articlesData);
//             // Bulk insert articles through the service
//             app(ArticleService::class)->createManyArticles($articlesData);
//             \Log::info("Batch processed successfully with " . count($articlesData) . " articles.");
//         } catch (\Exception $e) {
//             \Log::error("Error processing batch: {$e->getMessage()}", ['articlesData' => $articlesData]);
//         } finally {
//             // Clear batch data
//             $articlesData = [];
//         }
//     }


// }
