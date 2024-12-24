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

    public function getAllSources(array $filters, $perPage)
    {
        return $this->sourceRepository->getAll($filters, $perPage);
    }
}
