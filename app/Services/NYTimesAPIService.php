<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NYTimesAPIService
{
    protected string $apiKey;
    protected string $baseUrl ;

    public function __construct()
    {
        $this->apiKey = config('newsapi.sources.nytimes.api_key');
        $this->baseUrl = config('newsapi.sources.nytimes.base_url');

    }

    /**
     * Fetch articles from the New York Times API.
     *
     * @param string|null $query
     * @param string|null $beginDate (Format: YYYYMMDD)
     * @param string|null $endDate (Format: YYYYMMDD)
     * @param int $page
     * @return array
     * @throws \Exception
     */
    public function fetchArticles(?string $query = null, ?string $beginDate = null, ?string $endDate = null, int $page = 0): array
    {
        $params = [
            'api-key' => $this->apiKey,
            'q' => $query,
            'begin_date' => $beginDate,
            'end_date' => $endDate,
            'page' => $page,
            'sort' => 'newest',
            'fl' => 'web_url,headline,pub_date,section_name,source'
        ];

        $response = Http::get($this->baseUrl, $params);

        if ($response->successful()) {
            return $response->json()['response']['docs'] ?? [];
        }

        throw new \Exception('Failed to fetch articles: ' . $response->body());
    }
}
