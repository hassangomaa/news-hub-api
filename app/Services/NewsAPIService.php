<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsAPIService
{
    protected string $currentSource;

    public function __construct(string $source = 'newsapi')
    {
        $sources = config('newsapi.sources');
        if (!isset($sources[$source])) {
            throw new \Exception("Source {$source} not found in configuration.");
        }

        $this->currentSource = $source;
    }

    protected function getSourceConfig(): array
    {
        $sources = config('newsapi.sources');
        return $sources[$this->currentSource];
    }

    public function fetchTopHeadlines(string $country = 'us', string $category = 'technology'): array
    {
        $sourceConfig = $this->getSourceConfig();

        $response = Http::withHeaders([
            'Authorization' => $sourceConfig['api_key'],
        ])->get($sourceConfig['base_url'] . 'top-headlines', [
                    'country' => $country,
                    'category' => $category,
                ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to fetch data from NewsAPI: ' . $response->body());
    }
}
