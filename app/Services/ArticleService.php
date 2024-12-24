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

    public function getArticleById(string $id)
    {
        return $this->articleRepository->findById($id);
    }

    public function createArticle(array $data)
    {
        return $this->articleRepository->create($data);
    }

    public function updateArticle(string $id, array $data)
    {
        return $this->articleRepository->update($id, $data);
    }

    public function deleteArticle(string $id)
    {
        $this->articleRepository->delete($id);
    }
}
