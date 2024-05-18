<?php

namespace App\Jobs;

use App\Enum\Currencies;
use App\Models\Subscriber;
use App\Notifications\DailyExchangeRateNotification;
use App\Service\ExchangeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendDailyExchangeRateBatchNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Subscriber[] $subscribers */
    protected array $subscribers;

    protected ExchangeService $exchangeRateService;

    public function __construct(array $subscribers)
    {
        $this->subscribers = $subscribers;
        $this->exchangeRateService = new ExchangeService(Currencies::USD, [Currencies::UAH]);
    }

    public function handle(): void
    {
        $exchangeRate = $this->exchangeRateService->getExchangeRate();
        foreach ($this->subscribers as $subscribers) {
            $subscribers->notify(new DailyExchangeRateNotification($exchangeRate));
        }
    }
}
