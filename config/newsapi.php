<?php

return [
    'sources' => [
        'newsapi' => [
            'api_key' => env('NEWSAPI_API_KEY'),
            'base_url' => 'https://newsapi.org/v2/',
        ],
        'guardian' => [
            'api_key' => env('GUARDIAN_API_KEY'),
            'base_url' => 'https://content.guardianapis.com/',
        ],
    ],
];
