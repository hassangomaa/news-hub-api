<?php

namespace App\Services;

use App\Repositories\SourceRepository;

class SourceService
{
    protected $sourceRepository;

    public function __construct(SourceRepository $sourceRepository)
    {
        $this->sourceRepository = $sourceRepository;
    }

    public function getAllSources(array $filters, int $perPage, int $page)
    {
        return $this->sourceRepository->getAll($filters, $perPage, $page);
    }

    public function createOrUpdate(array $data)
    {
        return $this->sourceRepository->updateOrCreate(['name' => $data['name']], $data);
    }
}
