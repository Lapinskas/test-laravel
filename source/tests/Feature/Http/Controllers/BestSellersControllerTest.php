<?php

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
    $serviceMock = mock(BestSellersService::class);
    $serviceMock->shouldReceive('fetchData')
        ->once()
        ->andReturn(['mocked' => 'data']);

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
        ->and($response->getContent())->toBe('{"success":true,"rawData":{"mocked":"data"}}');
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
    expect($response->getStatusCode())->toBe(200)
        ->and($response->getContent())->toBe('{"success":false}');
})->with([
    [[
        'author' => 'John Doe',
        'title' => 'Book Title',
        'offset' => 20,
        'isbn' => ['0123456789'],
    ]],
]);
