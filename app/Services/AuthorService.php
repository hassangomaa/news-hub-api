<?php

namespace App\Services;

use App\Repositories\AuthorRepository;

class AuthorService
{
    protected $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * Get all authors with optional filters and pagination.
     */
    public function getAllAuthors(array $filters, int $perPage, int $page)
    {
        return $this->authorRepository->getAll($filters, $perPage, $page);
    }

    public function createOrUpdate(array $data)
    {
        return $this->authorRepository->updateOrCreate(['name' => $data['name']], $data);
    }
}
