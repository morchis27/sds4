<?php

namespace App\Builder;

use App\Enum\Currencies;
use Builder;

class UrlBuilder
{
    private const MAIN_CURRENCY_QUERY_PARAMETER_NAME = 'base';
    private const EXCHANGING_CURRENCY_QUERY_PARAMETER_NAME = 'symbols';

    private Url $url;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->url = new Url();
    }


    public function setHost(string $host): self
    {
        $this->url->host = $host;

        return $this;
    }

    public function setPath(string $path): self
    {
        $this->url->basePath = $path;

        return $this;
    }

    public function setEndpoint(string $endpoint): self
    {
        $this->url->endpoint = $endpoint;

        return $this;
    }

    public function setMainCurrency(Currencies $currency): self
    {
        $this->url->mainCurrency = $currency->value;

        return $this;
    }

    public function setConvertingCurrencies(array $currencies): self
    {
        $this->url->convertingCurrencies = $currencies;

        return $this;
    }

    public function get(): string
    {
        $url = $this->url->host . '/';
        $url .= $this->url->basePath . '/';
        $url .= $this->url->endpoint;
        $url .= '?' . self::MAIN_CURRENCY_QUERY_PARAMETER_NAME . '=' . $this->url->mainCurrency . '&';
        $url .= self::EXCHANGING_CURRENCY_QUERY_PARAMETER_NAME . '=' . $this->url->getConvertingCurrenciesStringForQuery();

        return $url;
    }
}
