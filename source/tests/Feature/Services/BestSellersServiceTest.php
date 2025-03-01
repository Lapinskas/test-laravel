<?php

use App\Dto\BestSellersRequestDto;
use App\Dto\BestSellersResponseDto;
use App\Interfaces\BestSellersApi;
use App\Interfaces\Cache as CacheRepository;
use App\Interfaces\Logging;
use App\Services\BestSellersService;

beforeEach(function () {
    // mock for dependencies
    $this->apiMock = mock(BestSellersApi::class);
    $this->cacheMock = mock(CacheRepository::class);
    $this->loggerMock = mock(Logging::class);

    // create service with mocked dependencies
    $this->service = new BestSellersService($this->apiMock, $this->cacheMock, $this->loggerMock);

    // create request DTO
    $this->dto = new BestSellersRequestDto(
        author: 'John Doe',
        title: 'Book Title',
        offset: 20,
        isbn: ['0123456789']
    );

    // create config
    config(['bestsellers.cacheTtl' => '3600']);
    config(['bestsellers.cachePrefix' => 'bestsellers_']);
});

it('fetches data from cache if available', function () {
    $cacheKey = $this->service->generateCacheKey($this->dto);
    $cachedData = ['data' => 'cached'];

    $this->loggerMock->shouldReceive('info')
        ->with('BestSellersService->fetchData call')
        ->once();

    $this->cacheMock->shouldReceive('get')
        ->with($cacheKey)
        ->once()
        ->andReturn($cachedData);

    // no real API call is made
    $this->apiMock->shouldNotReceive('fetchData');

    $result = $this->service->fetchData($this->dto);

    expect($result)->toBeInstanceOf(BestSellersResponseDto::class)
        ->and($result->cached)->toBeTrue()
        ->and($result->rawResponse)->toBe($cachedData);
});

it('fetches data from API and caches it if not in cache', function () {
    $cacheKey = $this->service->generateCacheKey($this->dto);
    $apiData = ['data' => 'from API'];

    $this->loggerMock->shouldReceive('info')
        ->with('BestSellersService->fetchData call')
        ->once();

    $this->cacheMock->shouldReceive('get')
        ->with($cacheKey)
        ->once()
        ->andReturn(null);

    $this->apiMock->shouldReceive('fetchData')
        ->with($this->dto)
        ->once()
        ->andReturn($apiData);

    $this->cacheMock->shouldReceive('put')
        ->with($cacheKey, $apiData, 3600)
        ->once();

    $result = $this->service->fetchData($this->dto);

    expect($result)->toBeInstanceOf(BestSellersResponseDto::class)
        ->and($result->cached)->toBeFalse()
        ->and($result->rawResponse)->toBe($apiData);
});

