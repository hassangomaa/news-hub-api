<?php

namespace App\Services;

use App\Repositories\ArticleRepository;

class ArticleService
{
    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getAllArticles(array $filters, int $perPage)
    {
        return $this->articleRepository->getAll($filters, $perPage);
    }


    public function createArticle(array $data)
    {
        return $this->articleRepository->create($data);
    }


    /**
     * Bulk create articles.
     *
     * @param array $articlesData
     * @return void
     */
    public function createManyArticles(array $articlesData)
    {
        // Filter out duplicates based on `url`
        $existingUrls = $this->articleRepository->getExistingUrls(array_column($articlesData, 'url'));

        $filteredArticles = array_filter($articlesData, function ($article) use ($existingUrls) {
            return !in_array($article['url'], $existingUrls);
        });

        if (!empty($filteredArticles)) {
            // dd($filteredArticles);
            // Perform bulk insert for filtered articles
            $this->articleRepository->insertMany($filteredArticles);
            \Log::info(count($filteredArticles) . " articles inserted successfully.");
        } else {
            \Log::info("No new articles to insert.");
        }
    }




    public function createOrUpdate(array $data)
    {
        return $this->articleRepository->updateOrCreate(['url' => $data['url']], $data);
    }



}
