<?php

namespace App\Services;

use App\Helper\ApiResponse;
use App\Interfaces\Services\AuthService;
use Error;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class AuthServiceImpl implements AuthService
{
  public function login(array $credentials)
  {
    if (!$token = Auth::attempt($credentials)) {
      throw new NotFoundHttpException('Invalid username or password');
    }

    return $this->respondToken($token);
  }

  public function refresh()
  {
    try {
      $token = Auth::refresh();

      return $this->respondToken($token);
    } catch (Throwable $th) {
      throw new UnauthorizedHttpException("", "Invalid or expired token");
    }
  }

  public function logout()
  {
    return Auth::logout();
  }

  public function me()
  {
    return Auth::user();
  }

  private function respondToken($token)
  {
    return [
      'token' => $token,
      'expires_in' => Auth::factory()->getTTL() * 60
    ];
  }
}
