<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Dto\BestSellersRequestDto;
use App\Rules\NumberArrayWithLeadingZeros;
use App\Rules\OffsetMultipleOfTwenty;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Request class for Best Sellers API that produce request DTO
 *
 * @see BestSellersController
 * @see BestSellersRequestDto
 */
class BestSellersRequest extends FormRequest
{
    /**
     * No authorisation at the moment
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,array<int, string|ValidationRule>>
     */
    public function rules(): array
    {
        return [
            /**
             * There is no restriction on the NYT side regarding
             * the length of the author parameter.
             * However, setting a limit of 100 characters looks
             * reasonable to prevent potential misuse of the NYT API,
             * especially since the API accepts partial strings for the search.
             */
            'author' => ['nullable', 'string', 'max:100'],

            /**
             * Same as for the author, setting a limit of 200
             * characters looks reasonable
             */
            'title' => ['nullable', 'string', 'max:200'],

            /**
             * NYT API allows non-integer offset, for example - 20.0
             * However, more strict rules applied for the wrapper API
             */
            'offset' => [new OffsetMultipleOfTwenty()],

            /**
             * NYT API allows poorly formatted ISBNs.
             * However, same as above, more strict rules applied
             */
            'isbn' => [new NumberArrayWithLeadingZeros()],
        ];
    }

    /**
     * Creates DTO from validated properties
     */
    public function toDto(): BestSellersRequestDto
    {
        /** @var array{
         *     author?: string,
         *     title?: string,
         *     offset?: int,
         *     isbn?: array{string},
         * } $validated
         */
        $validated = $this->validated();

        return new BestSellersRequestDto(
            author: $validated['author'] ?? null,
            title: $validated['title'] ?? null,
            offset: $validated['offset'] ?? null,
            isbn: $validated['isbn'] ?? null,
        );
    }
}
