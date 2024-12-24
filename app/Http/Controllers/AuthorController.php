<?php

namespace App\Http\Controllers;

use App\Http\Requests\Author\AuthorIndexRequest;
use App\Http\Resources\AuthorResource;
use App\Services\AuthorService;

class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * List all authors with optional filters and pagination.
     */
    public function index(AuthorIndexRequest $request)
    {
        $filters = $request->validated();
        $perPage = $filters['per_page'] ?? 10;

        $authors = $this->authorService->getAllAuthors($filters, $perPage);

        return AuthorResource::collection($authors);
    }
}
