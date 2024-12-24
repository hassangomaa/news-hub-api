<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getAll(array $filters = [], $perPage = 10)
    {
        $query = Category::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query->paginate($perPage);
    }
}
