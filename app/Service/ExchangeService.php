<?php

namespace App\Service;

use App\Builder\UrlBuilder;
use App\DTO\ExchangeDTO;
use App\Enum\Currencies;
use App\Enum\ExchangeUrn;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ExchangeService
{

    /** @var $convertingCurrencies Currencies[] */
    private array $convertingCurrencies;
    private Currencies $mainCurrency;

    public function __construct(Currencies $mainCurrency, array $convertingCurrencies)
    {
        $this->mainCurrency = $mainCurrency;
        $this->convertingCurrencies = $convertingCurrencies;
    }

    /**
     * @throws ConnectionException
     */
    public function getExchangeRate(): float
    {
        $exchangeDTO = new ExchangeDTO();
        $url = $this->getExchangeRateApiUrl(new UrlBuilder());

        $exchangeDTO->fillByResponse($this->getExchangeResponse($url));

        return $exchangeDTO->rate[Currencies::UAH->value];
    }

    /**
     * @throws ConnectionException
     */
    private function getExchangeResponse(string $url): Response
    {
        return Http::withOptions(['verify' => false])->withHeader('apikey', config('app.exchangeServiceApiKey'))->get($url);
    }

    private function getExchangeRateApiUrl(UrlBuilder $urlBuilder): string
    {
        return $urlBuilder
            ->setHost(config('app.exchangeServiceApiHost'))
            ->setPath(ExchangeUrn::EXCHANGE_RATES_DATA->value)
            ->setEndpoint(ExchangeUrn::LIVE->value)
            ->setMainCurrency($this->mainCurrency)
            ->setConvertingCurrencies($this->convertingCurrencies)
            ->get();
    }
}
