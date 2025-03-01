<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BestSellersRequest;
use Illuminate\Http\JsonResponse;

class BestSellersController extends Controller
{
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
     *             type="array",
     *
     *             @OA\Items(
     *                 type="object"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Invalid offset format"
     *             )
     *         )
     *     ),
     *
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
     *                  example="The offset must be a non-negative multiple of 20"
     *              )
     *          )
     *      ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function index(BestSellersRequest $request): JsonResponse
    {
        $dto = $request->toDto();
        return response()->json();
    }
}
