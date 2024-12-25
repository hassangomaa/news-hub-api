<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\IndexArticleRequest;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;
use App\Traits\ResponsesTrait;

class ArticleController extends Controller
{
    use ResponsesTrait;

    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * List all articles with filters and pagination.
     */
    public function index(IndexArticleRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $filters = $request->validated();

            $articles = $this->articleService->getAllArticles($filters, $filters['per_page'], $filters['page']);

            $meta = $this->generateMeta($articles);


            return $this->success(
                ArticleResource::collection($articles),
                'Articles retrieved successfully.',
                200,
                $meta
            );
        } catch (\Exception $e) {
            \Log::error("Error fetching articles: {$e->getMessage()}");
            return $this->failed(null, 'Failed to retrieve articles.', 500);
        }
    }


    /**
     * Create a new article.
     */
    public function store(CreateArticleRequest $request)
    {
        try {
            $article = $this->articleService->createArticle($request->validated());

            return $this->success(
                new ArticleResource($article),
                'Article created successfully.',
                201
            );
        } catch (\Exception $e) {
            \Log::error("Error creating article: {$e->getMessage()}");
            return $this->failed(null, 'Failed to create article.');
        }
    }
}
