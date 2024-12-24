<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryIndexRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Traits\ResponsesTrait;

class CategoryController extends Controller
{

    use ResponsesTrait;

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(CategoryIndexRequest $request): \Illuminate\Http\JsonResponse
    {

        try {
            // Validate and process the request data
            $filters = $request->validated();
            $perPage = $filters['per_page'] ?? 10;

            // Retrieve categories with filters and pagination
            $categories = $this->categoryService->getAllCategories($filters, $perPage);

            // Add pagination metadata
            $meta = [
                'total' => $categories->total(),
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
            ];

            // Return a standardized success response with the data and metadata
            return $this->success(CategoryResource::collection($categories), 'Categories retrieved successfully.', 200, $meta);
        } catch (\Exception $e) {
            // Log the error and return a standardized failure response
            \Log::error("Error retrieving categories: " . $e->getMessage());
            return $this->failed(null, 'Failed to retrieve categories. Please try again.', 500);
        }
    }


}
