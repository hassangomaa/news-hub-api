<?php

namespace App\Services;

class GuardianAPIService extends AbstractAPIService
{
    protected string $baseUrl;

    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('newsapi.sources.guardian.api_key');
        $this->baseUrl = config('newsapi.sources.guardian.base_url');
        $this->keyPlacement = 'query'; // Key is sent in the query
        $this->keyName = 'api-key'; // Query parameter name for the key
    }

    protected function mapResponse(array $data): array
    {
        return array_map(function ($article) {
            return [
                'title' => $article['webTitle'] ?? '',
                'description' => strip_tags($article['fields']['body'] ?? ''),
                'url' => $article['webUrl'] ?? '',
                'published_at' => $article['webPublicationDate'] ?? '',
                'source' => 'The Guardian',
                'author' => null, // Author is not provided by Guardian API
                'category' => $article['sectionId'] ?? 'General',
            ];
        }, $data['response']['results'] ?? []);
    }
}
