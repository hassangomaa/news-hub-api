<?php

namespace App\Http\Controllers;

use App\Http\Requests\Source\SourceIndexRequest;
use App\Http\Resources\SourceResource;
use App\Services\SourceService;

class SourceController extends Controller
{
    protected $sourceService;

    public function __construct(SourceService $sourceService)
    {
        $this->sourceService = $sourceService;
    }

    public function index(SourceIndexRequest $request)
    {
        $filters = $request->validated();
        $perPage = $filters['per_page'] ?? 10;

        $sources = $this->sourceService->getAllSources($filters, $perPage);

        return SourceResource::collection($sources);
    }
}
