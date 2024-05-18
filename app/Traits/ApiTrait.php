<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiTrait
{
    public function errorResponse(int $statusCode = 404): JsonResponse
    {
        return response()->json('', $statusCode, [], 0)->header('Content-Type', 'application/json');
    }

    public function successResponse(float|null $currency, int $statusCode = 200): JsonResponse
    {
        return response()->json($currency, $statusCode, [], JSON_NUMERIC_CHECK)->header('Content-Type', 'application/json');
    }
}
