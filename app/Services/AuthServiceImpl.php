<?php

namespace App\Services;

use App\Helper\ApiResponse;
use App\Interfaces\Services\AuthService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthServiceImpl implements AuthService
{
  public function login(array $credentials)
  {
    try {
      if (!$token = Auth::attempt($credentials)) {
        throw new NotFoundHttpException('Invalid username or password');
      }

      return $this->respondToken($token);
    } catch (HttpException $th) {
      throw new HttpResponseException(
        ApiResponse::response($th->getMessage(), $th->getStatusCode() ?? 500)
      );
    }
  }

  public function refresh()
  {
    try {
      $token = Auth::refresh();

      return $this->respondToken($token);
    } catch (HttpException $th) {
      throw new HttpResponseException(
        ApiResponse::response($th->getMessage(), $th->getStatusCode() ?? 500)
      );
    }
  }

  public function logout()
  {
    try {
      Auth::logout();
    } catch (HttpException $th) {
      throw new HttpResponseException(
        ApiResponse::response($th->getMessage(), $th->getStatusCode() ?? 500)
      );
    }
  }

  public function me()
  {
    try {
      return Auth::user();
    } catch (HttpException $th) {
      throw new HttpResponseException(
        ApiResponse::response($th->getMessage(), $th->getStatusCode() ?? 500)
      );
    }
  }

  private function respondToken($token)
  {
    return [
      'token' => $token,
      'expires_in' => Auth::factory()->getTTL() * 60
    ];
  }
}
