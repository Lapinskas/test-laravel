<?php

declare(strict_types=1);

namespace App\Http\Controllers;

/** @codeCoverageIgnore */
class SwaggerController extends Controller
{
    /**
     * @OA\Info(
     *      version="v1",
     *      title="Lendflow Assessment API",
     *      description="API documentation for Lendflow Assessment",
     *
     *      @OA\Contact(
     *          email="vlad.lapinskas@gmail.com"
     *      )
     * )
     */
    public function dummy(): void {} // required by Swagger
}
