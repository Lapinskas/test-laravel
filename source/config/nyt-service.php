<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party NYT Service
    |--------------------------------------------------------------------------
    |
    | This file is for storing the configuration for NYT service
    |
    */

    /*
    |--------------------------------------------------------------------------
    | NYT API URL
    |--------------------------------------------------------------------------
    |
    | URL for the bestsellers API call
    |
    */

    'apiUrl' => env('NYT_API_URL', 'https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json'),

    /*
    |--------------------------------------------------------------------------
    | NYT API Timeout
    |--------------------------------------------------------------------------
    |
    | API call timeout, in seconds
    |
    */

    'timeout' => env('NYT_API_TIMEOUT', 10), // in seconds

    /*
    |--------------------------------------------------------------------------
    | NYT API Retry Attempts
    |--------------------------------------------------------------------------
    |
    | Number of API call retry attempts before give up
    |
    */

    'retryAttempts' => env('NYT_API_RETRY_ATTEMPTS', 3),

    /*
    |--------------------------------------------------------------------------
    | NYT API Retry Delay
    |--------------------------------------------------------------------------
    |
    | Delay between tries, in seconds
    |
    */

    'retryDelay' => env('NYT_API_RETRY_DELAY', 1000), // in seconds

    /*
    |--------------------------------------------------------------------------
    | NYT API Cache key
    |--------------------------------------------------------------------------
    |
    | Cache key for the NYT API data
    |
    */

    'cacheKey' => env('NYT_API_CACHE_KEY', 'nyt_api_data'),

    /*
    |--------------------------------------------------------------------------
    | NYT API Cache TTL
    |--------------------------------------------------------------------------
    |
    | Time-to-live for NYT API data in the cache, in seconds
    |
    */
    'cacheTtl' => env('NYT_API_CACHE_TTL', 3600), // in seconds
];
