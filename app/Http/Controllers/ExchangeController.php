<?php

namespace App\Http\Controllers;

use App\Enum\Currencies;
use App\Service\ExchangeService;
use Exception;
use Illuminate\Http\JsonResponse;

class ExchangeController extends Controller
{
    public function getExchangeRate(): JsonResponse
    {
        try {
            $exchangeService = new ExchangeService(Currencies::USD, [Currencies::UAH]);

            return $this->successResponse($exchangeService->getExchangeRate());
        } catch (Exception $e) {
            return $this->errorResponse(400);
        }
    }
}
