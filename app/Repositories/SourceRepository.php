<?php

namespace App\Repositories;

use App\Models\Source;
use App\Repositories\Interfaces\CrudRepositoryInterface;

class SourceRepository implements CrudRepositoryInterface
{

    protected $model;

    public function __construct(Source $model)
    {
        $this->model = $model;
    }



    public function getAll(array $filters = [], $perPage, $page)
    {
        $query = $this->model::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }


    public function updateOrCreate(array $conditions, array $data)
    {
        return $this->model->updateOrCreate($conditions, $data);
    }
}
