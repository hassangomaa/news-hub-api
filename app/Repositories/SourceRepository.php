<?php

namespace App\Repositories;

use App\Models\Source;

class SourceRepository
{
    public function getAll(array $filters = [], $perPage = 10)
    {
        $query = Source::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query->paginate($perPage);
    }
}
