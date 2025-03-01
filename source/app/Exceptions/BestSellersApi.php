<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Helpers\Getter;
use Exception;
use Throwable;

/**
 * Custom error to return HTTP error code and error response body
 *
 * @property-read string $message
 * @property-read int $errorCode
 * @property-read string $responseBody
 */
class BestSellersApi extends Exception
{
    use Getter;

    public function __construct(
        string $message = '',
        protected int $errorCode = 0,
        protected string $responseBody = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array{
     *     message: string,
     *     errorCode: int,
     *     response: array<int|string, mixed>|string
     * }
     */
    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'errorCode' => $this->errorCode,
            'response' => $this->getResponseBody(),
        ];
    }

    /**
     * Returns array if response is JSON or keeps original string
     *
     * @return array<int|string, mixed>|string
     */
    public function getResponseBody(): array|string
    {
        $decodedResponse = json_decode(
            $this->responseBody,
            true
        );

        return is_array($decodedResponse)
            ? $decodedResponse
            : $this->responseBody;
    }
}
