<?php

declare(strict_types=1);

use App\Dto\BestSellersRequestDto;
use App\Exceptions\BestSellersApi;
use App\Repositories\NytBestSellersRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    // mock configuration
    Config::set('bestsellers.apiUrl', 'https://fake.com/svc/books/v3/lists.json');
    Config::set('bestsellers.timeout', 5);
    Config::set('bestsellers.retryAttempts', 3);
    Config::set('bestsellers.retryDelay', 2);
});

it('fetches data successfully from NYT API', function ($data) {
    Http::fake([
        '*' => Http::response(['results' => []], 200),
    ]);

    $repository = new NytBestSellersRepository();
    $dto = new BestSellersRequestDto(...$data);

    $response = $repository->fetchData($dto);

    expect($response)->toBeArray()
        ->and($response)->toHaveKey('results');
})->with([
    [[
        'author' => 'John Doe',
        'title' => 'Book Title',
        'offset' => 20,
        'isbn' => ['0123456789'],
    ]],
]);

it('throws an exception on failed request', function ($data) {
    Http::fake([
        '*' => Http::response([], 500),
    ]);

    $repository = new NytBestSellersRepository();
    $dto = new BestSellersRequestDto(...$data);

    $this->expectException(BestSellersApi::class);
    $repository->fetchData($dto);
})->with([
    [[
        'author' => 'John Doe',
        'title' => 'Book Title',
        'offset' => 20,
        'isbn' => ['0123456789'],
    ]],
]);

it('throws an exception on invalid JSON response', function ($data) {
    Http::fake([
        '*' => Http::response('Invalid JSON', 200),
    ]);

    $repository = new NytBestSellersRepository();
    $dto = new BestSellersRequestDto(...$data);

    $this->expectException(BestSellersApi::class);
    $repository->fetchData($dto);
})->with([
    [[
        'author' => 'John Doe',
        'title' => 'Book Title',
        'offset' => 20,
        'isbn' => ['0123456789'],
    ]],
]);

it('throws ApiException if response is unsuccessful', function ($data, $status) {
    Http::fake([
        '*' => Http::response('Error', $status),
    ]);

    $repository = new NytBestSellersRepository();
    $dto = new BestSellersRequestDto(...$data);

    $this->expectException(BestSellersApi::class);
    $this->expectExceptionMessage('NYT API request failed');
    $repository->fetchData($dto);
})->with([
    [[
        'author' => 'John Doe',
        'title' => 'Book Title',
        'offset' => 20,
        'isbn' => ['0123456789'],
    ], 401],
    [[
        'author' => 'Jane Doe',
        'title' => 'Another Book',
        'offset' => 10,
        'isbn' => ['9876543210'],
    ], 403],
    [[
        'author' => 'Alice',
        'title' => 'Some Book',
        'offset' => 5,
        'isbn' => ['1234567890'],
    ], 500],
]);
