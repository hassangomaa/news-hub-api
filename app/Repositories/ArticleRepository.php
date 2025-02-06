<?php

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\Interfaces\CrudRepositoryInterface;
use Illuminate\Support\Facades\Log;

class ArticleRepository implements CrudRepositoryInterface
{
    protected $model;

    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    /**
     * Get paginated and filtered articles.
     *
     * @param  int  $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll(array $filters, $perPage, $page)
    {
        $query = $this->model::query()->with(['category', 'author', 'source']);

        // Apply filters
        if (! empty($filters['title'])) {
            $query->where('title', 'LIKE', '%'.$filters['title'].'%');
        }

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['author_id'])) {
            $query->where('author_id', $filters['author_id']);
        }

        if (! empty($filters['source_id'])) {
            $query->where('source_id', $filters['source_id']);
        }

        if (! empty($filters['published_at'])) {
            $query->whereDate('published_at', $filters['published_at']);
        }

        return $query->paginate($perPage, ['*'], 'page', $page);

    }

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    /**
     * Get existing URLs from the database.
     *
     * @return array
     */
    public function getExistingUrls(array $urls)
    {
        return $this->model->whereIn('url', $urls)->pluck('url')->toArray();
    }

    /**
     * Bulk insert articles.
     *
     * @return void
     */
    public function insertMany(array $articlesData)
    {
        try {
            // Pre-filter to remove already existing URLs
            $existingUrls = $this->getExistingUrls(array_column($articlesData, 'url'));
            $filteredArticles = array_filter($articlesData, function ($article) use ($existingUrls) {
                return ! in_array($article['url'], $existingUrls);
            });

            // Add UUIDs manually since `insert` bypasses Eloquent events
            $processedArticles = array_map(function ($article) {
                $article['id'] = (string) \Illuminate\Support\Str::uuid();
                $article['created_at'] = now();
                $article['updated_at'] = now();

                return $article;
            }, $filteredArticles);

            // Perform bulk insert
            if (! empty($processedArticles)) {
                $this->model->insert($processedArticles);
            }
        } catch (\Exception $e) {
            Log::error('Error inserting articles: '.$e->getMessage());
            throw $e;
        }
    }

    public function updateOrCreate(array $conditions, array $data)
    {
        return $this->model->updateOrCreate($conditions, $data);
    }
}
