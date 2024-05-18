<?php
namespace App\Builder;


use App\Enum\Currencies;

class Url
{
    public ?string $host;
    public ?string $basePath;
    public ?string $endpoint;
    public ?string $mainCurrency;
    /**
     * @var Currencies[]|null
     */
    public ?array $convertingCurrencies;

    public function getConvertingCurrenciesStringForQuery(): string
    {
        return implode(',', array_map(function ($currency) {
            return $currency->value;
        }, $this->convertingCurrencies));
    }
}
