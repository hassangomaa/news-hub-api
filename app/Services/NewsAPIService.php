<?php

namespace App\Services;

class NewsAPIService extends AbstractAPIService
{
    protected string $baseUrl;

    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('newsapi.sources.newsapi.api_key');
        $this->baseUrl = config('newsapi.sources.newsapi.base_url');
        $this->keyPlacement = 'header'; // Key is sent in the header
        $this->keyName = 'x-api-key'; // Header name for the key
        // dd($this->apiKey, $this->baseUrl);

    }

    protected function mapResponse(array $data): array
    {
        return array_map(function ($article) {
            return [
                'title' => $article['title'] ?? '',
                'description' => $article['description'] ?? '',
                'url' => $article['url'] ?? '',
                'published_at' => $article['publishedAt'] ?? '',
                'source' => $article['source']['name'] ?? 'Unknown',
                'author' => $article['author'] ?? null,
                'category' => 'General', // No category in NewsAPI
            ];
        }, $data['articles'] ?? []);
    }
}
