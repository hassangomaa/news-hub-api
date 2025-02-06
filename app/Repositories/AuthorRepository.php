<?php

namespace App\Repositories;

use App\Models\Author;
use App\Repositories\Interfaces\CrudRepositoryInterface;

class AuthorRepository implements CrudRepositoryInterface
{
    protected $model;

    public function __construct(Author $model)
    {
        $this->model = $model;
    }

    /**
     * Get a paginated list of authors with optional filters.
     */
    public function getAll(array $filters, $perPage, $page)
    {
        $query = $this->model::query();

        if (! empty($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        return $query->paginate($perPage, ['*'], 'page', $page);

    }

    public function updateOrCreate(array $conditions, array $data)
    {
        return $this->model->updateOrCreate($conditions, $data);
    }
}
