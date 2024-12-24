<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GuardianAPIService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('newsapi.sources.guardian.api_key');
        $this->baseUrl = config('newsapi.sources.guardian.base_url');
    }

    /**
     * Fetch articles from The Guardian API.
     *
     * @param string $section
     * @param string $fromDate
     * @param int $pageSize
     * @return array
     */
    public function fetchArticles(string $section = 'technology', string $fromDate = '2024-01-01', int $pageSize = 50): array
    {
        try {
            $response = Http::get("{$this->baseUrl}search", [
                'api-key' => $this->apiKey,
                'section' => $section,
                'from-date' => $fromDate,
                'show-fields' => 'headline,body',
                'page-size' => $pageSize,
            ]);

            if ($response->successful()) {
                return $response->json()['response']['results'] ?? [];
            }

            throw new \Exception('Failed to fetch articles: ' . $response->body());
        } catch (\Exception $e) {
            \Log::error('Error fetching articles from Guardian API: ' . $e->getMessage());
            throw $e;
        }
    }
}
