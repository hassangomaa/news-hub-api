<?php

namespace App\Repositories;

use App\Models\Author;

class AuthorRepository
{
    /**
     * Get a paginated list of authors with optional filters.
     */
    public function getAll(array $filters = [], $perPage = 10)
    {
        $query = Author::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query->paginate($perPage);
    }
}
