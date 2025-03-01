<?php

use Tests\RequestFactories\BestSellerRequestFactory;

it('converts validated data to DTO correctly', function ($input, $expected) {
    // get DTO and validate it
    $dto = BestSellerRequestFactory::new()
        ->state($input)
        ->toDto();

    expect($dto->author)->toBe($expected['author'])
        ->and($dto->title)->toBe($expected['title'])
        ->and($dto->offset)->toBe($expected['offset'])
        ->and($dto->isbn)->toBe($expected['isbn']);
})->with([
    [
        'input' => [],
        'expected' => ['author' => null, 'title' => null, 'offset' => null, 'isbn' => null],
    ],
    [
        'input' => ['author' => 'John Doe', 'title' => 'Book', 'offset' => 20, 'isbn' => ['0123456789']],
        'expected' => ['author' => 'John Doe', 'title' => 'Book', 'offset' => 20, 'isbn' => ['0123456789']],
    ],
    [
        'input' => ['author' => '', 'title' => '', 'offset' => 0, 'isbn' => ['0000000000000']],
        'expected' => ['author' => '', 'title' => '', 'offset' => 0, 'isbn' => ['0000000000000']],
    ],
]);
