<?php

use App\Dto\BestSellersRequestDto;
use App\Dto\BestSellersResponseDto;
use App\Exceptions\BestSellersApi;
use App\Http\Controllers\BestSellersController;
use App\Interfaces\Logging;
use App\Services\BestSellersService;
use Tests\RequestFactories\BestSellersRequestFactory;

it('logs DTO contents and returns success', function ($data) {
    // mock the logger
    $loggerMock = mock(Logging::class);
    $loggerMock->shouldReceive('info')
        ->once()
        ->with('BestSellers request', $data);

    // mock the service
    $responseDto = new BestSellersResponseDto(
        cached: false,
        rawResponse: ['mocked' => 'data']
    );
    $serviceMock = mock(BestSellersService::class);
    $serviceMock->shouldReceive('fetchData')
        ->once()
        ->andReturn($responseDto);

    // bind mock to the container
    app()->instance(BestSellersService::class, $serviceMock);

    // create request
    $request = BestSellersRequestFactory::new()->state($data)->createRequest();
    $request->setContainer(app())->validateResolved();

    // run controller with the mock
    $controller = new BestSellersController($loggerMock);
    $response = $controller->index($request, $serviceMock);

    // assert results
    expect($response->getStatusCode())->toBe(200)
        ->and($response->getContent())->toBe('{"success":true,"cached":false,"rawResponse":{"mocked":"data"}}');
})->with([
    [[
        'author' => 'John Doe',
        'title' => 'Book Title',
        'offset' => 20,
        'isbn' => ['0123456789'],
    ]],
]);

it('handles exception from NytApiService and returns failure', function ($data) {
    // mock the logger
    $logger = mock(Logging::class);
    $logger->shouldReceive('info')
        ->once()
        ->with('BestSellers request', $data);
    $logger->shouldReceive('error')
        ->once()
        ->withArgs(function (string $message, array $context) use ($data) {
            return str_contains($message, 'API error') && $context === $data;
        });

    // mock the NytApiService to throw an exception
    $serviceMock = mock(BestSellersService::class);
    $serviceMock->shouldReceive('fetchData')
        ->once()
        ->andThrow(new Exception('API error'));

    // bind mock to the container
    app()->instance(BestSellersService::class, $serviceMock);

    // create request
    $request = BestSellersRequestFactory::new()->state($data)->createRequest();
    $request->setContainer(app())->validateResolved();

    // run controller with the mocked service
    $controller = new BestSellersController($logger);
    $response = $controller->index($request, $serviceMock);

    // assert results
    expect($response->getStatusCode())->toBe(500)
        ->and($response->getContent())->toBe('{"success":false,"error":"Internal server error"}');
})->with([
    [[
        'author' => 'John Doe',
        'title' => 'Book Title',
        'offset' => 20,
        'isbn' => ['0123456789'],
    ]],
]);

it('handles BestSellersApi exception and returns API error response', function ($data) {
    // mock the logger
    $logger = mock(Logging::class);
    $logger->shouldReceive('info')
        ->once()
        ->with('BestSellers request', $data);
    $logger->shouldReceive('error')
        ->once()
        ->withArgs(function (string $message, array $context) use ($data) {
            return $message === 'NYT API request failed' &&
                $context['request'] === $data &&
                $context['error']['message'] === 'NYT API request failed' &&
                $context['error']['errorCode'] === 429 &&
                $context['error']['response'] === ['error' => 'Rate limit exceeded']; // Изменено на 'response'
        });

    // mock the service to throw BestSellersApi exception
    $exception = new BestSellersApi(
        message: 'NYT API request failed',
        errorCode: 429,
        responseBody: '{"error": "Rate limit exceeded"}'
    );
    $serviceMock = mock(BestSellersService::class);
    $serviceMock->shouldReceive('fetchData')
        ->once()
        ->andThrow($exception);

    // bind mock to the container
    app()->instance(BestSellersService::class, $serviceMock);

    // create request
    $request = BestSellersRequestFactory::new()->state($data)->createRequest();
    $request->setContainer(app())->validateResolved();

    // run controller with the mocked service
    $controller = new BestSellersController($logger);
    $response = $controller->index($request, $serviceMock);

    // assert results
    expect($response->getStatusCode())->toBe(429)
        ->and($response->getContent())->toBe('{"success":false,"error":"NYT API request failed","rawResponse":{"error":"Rate limit exceeded"}}');
})->with([
    [[
        'author' => 'John Doe',
        'title' => 'Book Title',
        'offset' => 20,
        'isbn' => ['0123456789'],
    ]],
]);
