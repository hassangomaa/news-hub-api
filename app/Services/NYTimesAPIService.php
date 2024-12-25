<?php



namespace App\Services;

class NYTimesAPIService extends AbstractAPIService
{
    protected string $baseUrl;
    protected string $apiKey;
    public function __construct()
    {
        $this->apiKey = config('newsapi.sources.nytimes.api_key');
        $this->baseUrl = config('newsapi.sources.nytimes.base_url');
        $this->keyPlacement = 'query';
        $this->keyName = 'api-key';
    }

    protected function mapResponse(array $data): array
    {
        return array_map(function ($article) {
            return [
                'title' => $article['headline']['main'] ?? 'Unknown Title',
                'description' => $article['headline']['kicker'] ?? '',
                'url' => $article['web_url'] ?? '',
                'published_at' => $article['pub_date'] ?? '',
                'source' => $article['source'] ?? 'NYTimes',
                'author' => $article['byline']['original'] ?? null,
                'category' => $article['section_name'] ?? 'General',
            ];
        }, $data['response']['docs'] ?? []);
    }

    public function fetchArticles(?string $query = null, ?string $beginDate = null, ?string $endDate = null, int $page = 0): array
    {
        $params = [
            'api-key' => $this->apiKey,
            'q' => $query,
            'begin_date' => $beginDate,
            'end_date' => $endDate,
            'page' => $page,
            'sort' => 'newest',
            'fl' => 'web_url,headline,pub_date,section_name,source',
        ];

        return $this->fetch('articlesearch.json', $params);
    }
}
