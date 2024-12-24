<?php

namespace App\Http\Controllers;

use App\Http\Requests\Source\SourceIndexRequest;
use App\Http\Resources\SourceResource;
use App\Services\SourceService;
use App\Traits\ResponsesTrait;

class SourceController extends Controller
{

    use ResponsesTrait;

    protected $sourceService;

    public function __construct(SourceService $sourceService)
    {
        $this->sourceService = $sourceService;
    }

    public function index(SourceIndexRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $filters = $request->validated();
            $perPage = $filters['per_page'] ?? 10;

            $sources = $this->sourceService->getAllSources($filters, $perPage);

            // Add pagination metadata
            $meta = [
                'total' => $sources->total(),
                'current_page' => $sources->currentPage(),
                'last_page' => $sources->lastPage(),
                'per_page' => $sources->perPage(),
            ];

            return $this->success(
                SourceResource::collection($sources),
                'Sources retrieved successfully.',
                200,
                $meta
            );
        } catch (\Exception $e) {
            \Log::error("Error retrieving sources: {$e->getMessage()}");
            return $this->failed(null, 'Failed to retrieve sources. Please try again.', 500);
        }
    }






}
