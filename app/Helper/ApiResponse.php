<?php

namespace App\Helper;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ApiResponse
{
  public static function responseWithData($data, $message, $code = Response::HTTP_OK)
  {
    if ($data instanceof ResourceCollection) {
      $responseData = $data->response()->getData(true);
      return response()->json(array_filter([
        'message' => $message,
        'data' => $responseData['data'],
        'meta' => $responseData['meta'] ?? null,
        'links' => $responseData['links'] ?? null,
      ]), $code);
    }

    return response()->json([
      'message' => $message,
      'data' => $data,
    ], $code);
  }

  public static function response($message, $code = Response::HTTP_OK)
  {
    return response()->json([
      'message' => $message,
    ], $code);
  }
}
