<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryIndexRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(CategoryIndexRequest $request)
    {
        $filters = $request->validated();
        $perPage = $filters['per_page'] ?? 10;

        $categories = $this->categoryService->getAllCategories($filters, $perPage);

        return CategoryResource::collection($categories);
    }
}
