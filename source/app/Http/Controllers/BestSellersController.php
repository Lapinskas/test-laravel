<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\BestSellersRequest;
use App\Interfaces\Logging;
use App\Services\NytApiService;
use Exception;
use Illuminate\Http\JsonResponse;

class BestSellersController extends Controller
{
    // Use DI to set a logger
    public function __construct(protected Logging $logger) {}

    /**
     * @OA\Post(
     *     path="/best-sellers",
     *     summary="Get list of best sellers",
     *     description="This endpoint a wrapper over NYT API",
     *     tags={"Best Sellers"},
     *
     *     @OA\Parameter(
     *          name="Accept",
     *          in="header",
     *          required=true,
     *
     *          @OA\Schema(type="string", default="application/json"),
     *          description="Indicates that the client expects a JSON response"
     *      ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"author", "title", "offset", "isbn"},
     *
     *             @OA\Property(
     *                 property="author",
     *                 type="string",
     *                 description="Author of the book",
     *                 example="John Doe"
     *             ),
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 description="Title of the book",
     *                 example="Best Book Ever"
     *             ),
     *             @OA\Property(
     *                 property="offset",
     *                 type="integer",
     *                 description="Offset for pagination",
     *                 example=20
     *             ),
     *             @OA\Property(
     *                 property="isbn",
     *                 type="array",
     *                 items=@OA\Items(type="string"),
     *                 description="ISBN numbers of the books",
     *                 example={"9783161484100", "9780123456"}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved best sellers",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example=true
     *              ),
     *              @OA\Property(
     *                   property="rawData",
     *                    type="object"
     *               )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="ERROR"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorised"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="The offset must be a multiple of 20"
     *              )
     *          )
     *      ),
     *
     *      @OA\Response(
     *           response=429,
     *           description="Rate limit quota violation",
     *
     *           @OA\JsonContent(
     *               type="object",
     *
     *               @OA\Property(
     *                   property="fault",
     *                   type="object"
     *               )
     *           )
     *       ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function index(
        BestSellersRequest $request,
        NytApiService $service
    ): JsonResponse {
        // get strongly typed DTO from validated request
        $dto = $request->toDto();

        /**
         * log new request
         *
         * @var array<string, mixed> $context
         */
        $context = $dto->toArray();
        $this->logger->info('BestSellers request', $context);

        try {
            $data = $service->fetchData($dto);

            return response()->json([
                'success' => true,
                'rawData' => $data,
            ]);
        } catch (Exception $exception) {
            // log error
            $this->logger->error($exception->getMessage(), $context);

            return response()->json([
                'success' => false,
            ]);
        }
    }
}
