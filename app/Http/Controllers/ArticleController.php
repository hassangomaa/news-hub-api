<?php


namespace App\Http\Controllers;

use App\Http\Requests\Article\IndexArticleRequest;
use App\Http\Requests\Article\ShowArticleRequest;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Requests\Article\DeleteArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * List all articles with filters and pagination.
     */
    public function index(IndexArticleRequest $request)
    {
        $filters = $request->validated();
        $perPage = $filters['per_page'] ?? 10;
        unset($filters['per_page']);

        $articles = $this->articleService->getAllArticles($filters, $perPage);

        return ArticleResource::collection($articles);
    }

    /**
     * Show a single article by ID.
     */
    public function show(ShowArticleRequest $request, $id)
    {
        $article = $this->articleService->getArticleById($id);

        return new ArticleResource($article);
    }

    /**
     * Create a new article.
     */
    public function store(CreateArticleRequest $request)
    {
        $article = $this->articleService->createArticle($request->validated());

        return new ArticleResource($article);
    }

    /**
     * Update an article by ID.
     */
    public function update(UpdateArticleRequest $request, $id)
    {
        $article = $this->articleService->updateArticle($id, $request->validated());

        return new ArticleResource($article);
    }

    /**
     * Delete an article by ID.
     */
    public function destroy(DeleteArticleRequest $request, $id)
    {
        $this->articleService->deleteArticle($id);

        return response()->json(['message' => 'Article deleted successfully.'], 200);
    }
}
