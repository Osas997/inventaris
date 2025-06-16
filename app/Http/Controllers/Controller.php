<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Inagata API Documentation",
 *     version="1.0.0",
 * )
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Localhost"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    //
}
