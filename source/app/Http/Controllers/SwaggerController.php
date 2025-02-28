<?php

namespace App\Http\Controllers;

class SwaggerController extends Controller
{
    /**
     * @OA\Info(
     *      version="1.0",
     *      title="Lendflow Assessment API",
     *      description="API documentation for Lendflow Assessment",
     *
     *      @OA\Contact(
     *          email="vlad.lapinskas@gmail.com"
     *      )
     * )
     */
    public function dummy() {} // required by Swagger
}
