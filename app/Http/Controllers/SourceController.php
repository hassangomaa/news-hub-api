<?php

namespace App\Http\Controllers;

use App\Http\Requests\Source\SourceIndexRequest;
use App\Http\Resources\SourceResource;
use App\Services\SourceService;
use App\Traits\ResponsesTrait;
use Illuminate\Support\Facades\Log;

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

            $sources = $this->sourceService->getAllSources($filters, $filters['per_page'], $filters['page']);

            $meta = $this->generateMeta($sources);

            return $this->success(
                SourceResource::collection($sources),
                'Sources retrieved successfully.',
                200,
                $meta
            );
        } catch (\Exception $e) {
            Log::error("Error retrieving sources: {$e->getMessage()}");

            return $this->failed(null, 'Failed to retrieve sources. Please try again.', 500);
        }
    }
}
