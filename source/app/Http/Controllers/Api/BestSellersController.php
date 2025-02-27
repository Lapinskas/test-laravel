<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BestSellersController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1.0/best-sellers",
     *     summary="Get list of best sellers",
     *     tags={"Best Sellers"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *         )
     *     )
     * )
     */
    public function index() : JsonResponse
    {
        return response()->json([
            'success' => true,
        ]);
    }
}
