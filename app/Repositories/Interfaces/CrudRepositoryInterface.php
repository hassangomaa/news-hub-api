<?php

namespace App\Repositories\Interfaces;

interface CrudRepositoryInterface
{
    public function getAll(array $filters, $perPage, $page);

    public function updateOrCreate(array $conditions, array $data);
}
