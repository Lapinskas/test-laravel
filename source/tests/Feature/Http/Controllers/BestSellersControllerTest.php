<?php

use App\Http\Controllers\BestSellersController;
use App\Interfaces\Logging;
use Tests\RequestFactories\BestSellersRequestFactory;

it('logs DTO contents and returns success', function ($data) {
    // mock the logger
    $logger = mock(Logging::class);
    $logger->shouldReceive('info')
        ->once()
        ->with('BestSellers request', $data);

    // create request
    $request = BestSellersRequestFactory::new()->state($data)->createRequest();
    $request->setContainer(app())->validateResolved();

    // run controller with the mock
    $controller = new BestSellersController($logger);
    $response = $controller->index($request);

    // assert results
    expect($response->getStatusCode())->toBe(200)
        ->and($response->getContent())->toBe('[]');
})->with([
    [[
        'author' => 'John Doe',
        'title' => 'Book Title',
        'offset' => 20,
        'isbn' => ['0123456789'],
    ]],
]);
