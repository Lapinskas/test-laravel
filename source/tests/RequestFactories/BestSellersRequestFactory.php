<?php

namespace Tests\RequestFactories;

use App\Dto\BestSellersRequestDto;
use App\Http\Requests\BestSellersRequest;
use Closure;
use Worksome\RequestFactories\RequestFactory;

class BestSellersRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [];
    }

    /**
     * Helper to create request
     */
    public function createRequest(): BestSellersRequest
    {
        return BestSellersRequest::create(
            route('best-sellers.index'),
            'POST',
            $this->create()
        );
    }


    /**
     * Helper to create request DTO directly
     */
    public function toDto(): BestSellersRequestDto
    {
        // create request instance
        $request = $this->createRequest();

        // set DI container and force validation
        $request
            ->setContainer(app())
            ->validateResolved();

        // return request DTO
        return $request->toDto();
    }
}
