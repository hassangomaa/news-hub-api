<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

abstract class AbstractAPIService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $keyPlacement; // 'header' or 'query'
    protected string $keyName; // e.g., 'x-api-key' for headers or 'api-key' for query

    abstract protected function mapResponse(array $data): array;

    public function fetch(string $endpoint, array $params = []): array
    {
        // dd($this->apiKey, $this->baseUrl, $this->keyPlacement, $this->keyName);
        try {
            if ($this->keyPlacement === 'header') {
                $headers = [$this->keyName => $this->apiKey];
                $response = Http::withHeaders($headers)->get("{$this->baseUrl}{$endpoint}", $params);
            } else { // 'query'
                $params[$this->keyName] = $this->apiKey;
                $response = Http::get("{$this->baseUrl}{$endpoint}", $params);
                
            }
            // dd($response);

            if ($response->successful()) {
                // dd($response->json());
                return $this->mapResponse($response->json());
            }

            throw new \Exception("API call failed: {$response->body()}");
        } catch (\Exception $e) {
            \Log::error("Error fetching data: {$e->getMessage()}");
            throw $e;
        }
    }
}
