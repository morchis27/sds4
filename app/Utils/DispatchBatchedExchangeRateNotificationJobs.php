<?php

namespace App\Utils;

use App\Jobs\SendDailyExchangeRateBatchNotifications;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Collection;

class DispatchBatchedExchangeRateNotificationJobs
{
    private int $batchSize = 500;

    public function __invoke(): void
    {
        try {
            Subscriber::query()
                ->whereNotNull('email_verified_at')
                ->chunk($this->batchSize, function ($subscribers) {
                    /** @var Collection $subscribers */
                    dispatch(new SendDailyExchangeRateBatchNotifications($subscribers->all()));
                });
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
