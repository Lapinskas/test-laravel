<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dto\BestSellersRequestDto as Request;
use App\Exceptions\BestSellersApi as ApiException;
use App\Helpers\Config;
use App\Interfaces\BestSellersApi;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * This repository implements NYT API call to get Best Sellers
 */
class NytBestSellersRepository implements BestSellersApi
{
    private string $url;

    private int $timeout;

    private int $retryAttempts;

    private int $retryDelay;

    public function __construct()
    {
        // configuration
        $this->url = Config::string('bestsellers.apiUrl');
        $this->timeout = Config::int('bestsellers.timeout');
        $this->retryAttempts = Config::int('bestsellers.retryAttempts');
        $this->retryDelay = Config::int('bestsellers.retryDelay');
    }

    /**
     * @return array<mixed, mixed>
     *
     * @throws ApiException
     */
    public function fetchData(Request $dto): array
    {
        try {
            $params = $this->getParams($dto);
            $response = $this->makeRequest($params);
            $data = $response->json();

            if (! is_array($data)) {
                throw new ApiException(
                    message: 'NYT API response is not a valid JSON array',
                    errorCode: 200,
                    responseBody: $response->body()
                );
            }

            return $data;
        } catch (RequestException $e) {
            throw new ApiException(
                message: 'NYT API request failed',
                errorCode: $e->response->status(),
                responseBody: $e->response->body(),
            );
        }
    }

    /**
     * Method prepared GET request params
     *
     * @return array<string, bool|string|int>
     */
    private function getParams(Request $dto): array
    {
        return array_filter([
            'author' => $dto->author,
            'title' => $dto->title,
            'offset' => $dto->offset,
            'isbn' => $dto->isbn
                ? implode(';', $dto->isbn) : null,

            // use env() and not config() as it might cache secret values
            // @phpstan-ignore-next-line larastan.noEnvCallsOutsideOfConfig
            'api-key' => env('NYT_API_KEY'),
        ], fn ($value) => $value !== null);
    }

    /**
     * @param  array<string, bool|string|int>  $params
     *
     * @throws ApiException
     */
    private function makeRequest(array $params): Response
    {
        // call API
        $response = Http::timeout($this->timeout)
            ->retry(
                times: $this->retryAttempts,
                sleepMilliseconds: $this->retryDelay * 1000
            )
            ->get(
                url: $this->url,
                query: $params
            );

        if (! $response->successful()) {
            throw new ApiException(
                message: 'NYT API request failed',
                errorCode: $response->status(),
                responseBody: $response->body()
            );
        }

        return $response;
    }
}
