<?php

namespace App\DTO;
use Illuminate\Http\Client\Response;

class ExchangeDTO
{
    public string $baseCurrency;
    public array $rate;

    public function fillByResponse(Response $response): void
    {
        $responseBodyArray = $response->json();
        $this->baseCurrency = $responseBodyArray['base'];
        $this->rate = $responseBodyArray['rates'];
    }
}
