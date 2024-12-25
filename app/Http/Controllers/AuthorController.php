<?php

namespace App\Http\Controllers;

use App\Http\Requests\Author\AuthorIndexRequest;
use App\Http\Resources\AuthorResource;
use App\Services\AuthorService;
use App\Traits\ResponsesTrait;

class AuthorController extends Controller
{
    use ResponsesTrait;

    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * List all authors with optional filters and pagination.
     */
    public function index(AuthorIndexRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $filters = $request->validated();

            $authors = $this->authorService->getAllAuthors($filters, $filters['per_page'], $filters['page']);

            $meta = $this->generateMeta($authors);

            return $this->success(
                AuthorResource::collection($authors),
                'Authors retrieved successfully.',
                200,
                $meta
            );
        } catch (\Exception $e) {
            \Log::error("Error retrieving authors: {$e->getMessage()}");
            return $this->failed(null, 'Failed to retrieve authors. Please try again.', 500);
        }
    }


}
