<?php

namespace App\Listeners;

use App\Events\Subscribed;
use App\Notifications\VerifyEmailQueued;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSubscribedNotification implements ShouldQueue
{
    private bool $shouldBeVerified;

    public function __construct()
    {
        $this->shouldBeVerified = env('SHOULD_BE_VERIFIED', true);
    }

    /**
     * Handle the event.
     */
    public function handle(Subscribed $event): void
    {
        $subscriber = $event->subscriber;
        if ($this->shouldBeVerified) {
            $subscriber->notify(new VerifyEmailQueued());
        }

        if (!$this->shouldBeVerified) {
            $subscriber->forceFill([
                'email_verified_at' => Carbon::now()->getTimestamp(),
            ])->save();
        }
    }
}
