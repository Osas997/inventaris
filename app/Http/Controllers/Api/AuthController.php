<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\Interfaces\Services\AuthService;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     operationId="login",
     *     tags={"Auth"},
     *     summary="Login",
     *     description="Endpoint untuk melakukan login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"username", "password"},
     *                 @OA\Property(property="username", type="string", example="username"),
     *                 @OA\Property(property="password", type="string", format="password", example="123456")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *          )
     *     ),
     * )
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $result = $this->authService->login($credentials);
        return ApiResponse::responseWithData(new LoginResource($result), 'Login successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/auth/me",
     *      operationId="me",
     *      tags={"Auth"},
     *      summary="Me",
     *      description="Endpoint untuk mendapatkan data Current user",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *          )
     *     ),
     *     )
     */
    public function me()
    {
        $me = $this->authService->me();
        return ApiResponse::responseWithData(new UserResource($me), 'Success get current user');
    }


    /**
     * @OA\Post(
     *      path="/api/auth/refresh",
     *      operationId="refresh",
     *      tags={"Auth"},
     *      summary="refresh",
     *      description="Endpoint untuk refresh token",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *          )
     *     ),
     *)
     */
    public function refresh()
    {
        $result = $this->authService->refresh();
        return ApiResponse::responseWithData(new LoginResource($result), 'Success refresh token');
    }

    /**
     * @OA\Post(
     *      path="/api/auth/logout",
     *      operationId="logout",
     *      tags={"Auth"},
     *      summary="Logout",
     *      description="Endpoint untuk logout",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *          )
     *     ),
     * )
     */
    public function logout()
    {
        $this->authService->logout();
        return ApiResponse::response('Logout successfully');
    }
}
