<?php

namespace Tests\RequestFactories;

use App\Dto\BestSellersRequestDto;
use App\Http\Requests\BestSellersRequest;
use Worksome\RequestFactories\RequestFactory;

class BestSellerRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [];
    }

    /**
     * Helper to create request DTO directly
     */
    public function toDto(): BestSellersRequestDto
    {
        // create request instance
        $request = BestSellersRequest::create(
            route('best-sellers.index'),
            'POST',
            $this->create()
        );

        // set DI container and force validation
        $request
            ->setContainer(app())
            ->validateResolved();

        // return request DTO
        return $request->toDto();
    }
}
