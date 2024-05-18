<?php

namespace App\Enum;

enum ExchangeUrn: string
{
    case EXCHANGE_RATES_DATA = 'exchangerates_data';
    case LIVE = 'latest';
}
