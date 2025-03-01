<?php

use App\Repositories\RedisCacheRepository;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    // mock Cache facade
    Cache::shouldReceive('store')
        ->with('redis')
        ->once()
        ->andReturnSelf();

    $this->repository = new RedisCacheRepository();
    $this->decodedValue = ['response' => 'cached_value'];
    $this->encodedValue = json_encode(['response' => 'cached_value']);
});

it('gets value from cache by key', function () {
    Cache::shouldReceive('get')
        ->with('test_key')
        ->once()
        ->andReturn($this->encodedValue);

    $result = $this->repository
        ->get('test_key');

    expect($result)->toBe($this->decodedValue);
});

it('puts value into cache with TTL', function () {
    Cache::shouldReceive('put')
        ->with('test_key', $this->encodedValue, 3600)
        ->once();

    $this->repository
        ->put('test_key', $this->decodedValue, 3600);
});

it('checks if key exists in cache', function () {
    Cache::shouldReceive('has')
        ->with('test_key')
        ->once()
        ->andReturn(true);

    $result = $this->repository->has('test_key');

    expect($result)->toBeTrue();
});

it('forgets value from cache by key', function () {
    Cache::shouldReceive('forget')
        ->with('test_key')
        ->once();

    $this->repository->forget('test_key');
});
