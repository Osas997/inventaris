<?php

namespace App\Helper;

use Illuminate\Http\Response;

class ApiResponse
{
  public static function responseWithData($data, $message, $code = Response::HTTP_OK)
  {
    return response()->json([
      'message' => $message,
      'data' => $data
    ], $code);
  }

  public static function response($message, $code = Response::HTTP_OK)
  {
    return response()->json([
      'message' => $message,
    ], $code);
  }
}
