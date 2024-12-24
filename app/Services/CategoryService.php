<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(array $filters, $perPage)
    {
        return $this->categoryRepository->getAll($filters, $perPage);
    }


    public function createOrUpdate(array $data)
    {
        return $this->categoryRepository->updateOrCreate(['name' => $data['name']], $data);
    }

}
