<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    /**
     * Get paginated and filtered articles.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll(array $filters = [], $perPage = 10)
    {
        $query = Article::query();

        // Apply filters
        if (!empty($filters['title'])) {
            $query->where('title', 'LIKE', '%' . $filters['title'] . '%');
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['author_id'])) {
            $query->where('author_id', $filters['author_id']);
        }

        if (!empty($filters['source_id'])) {
            $query->where('source_id', $filters['source_id']);
        }

        if (!empty($filters['published_at'])) {
            $query->whereDate('published_at', $filters['published_at']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Get a single article by ID.
     *
     * @param string $id
     * @return \App\Models\Article
     */
    public function findById(string $id)
    {
        return Article::findOrFail($id);
    }

    public function create(array $data)
    {
        return Article::create($data);
    }

    public function update(string $id, array $data)
    {
        $article = $this->findById($id);
        $article->update($data);
        return $article;
    }

    public function delete(string $id)
    {
        $article = $this->findById($id);
        $article->delete();
    }
}
