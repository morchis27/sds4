<?php

namespace App\Http\Controllers;

use App\Exceptions\AlreadyExistsException;
use App\Http\Requests\StoreSubscriberRequest;
use App\Models\Subscriber;
use App\Service\Subscription\SubscriptionService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * @throws AlreadyExistsException
     * @throws Exception
     */
    public function subscribe(StoreSubscriberRequest $request): JsonResponse
    {
        $email = $request->get('email');
        $subscriber = Subscriber::where('email', $email)->first();
        if($subscriber) {
            throw new AlreadyExistsException();
        }

        $subscriptionService = new SubscriptionService();

        $subscriptionService->subscribe($email);

        return $this->successResponse(null, 200);
    }

    public function verify($id, Request $request): View
    {
        if (!$request->hasValidSignature()) {
            return view('auth/email-error-verified');
        }
        /** @var Subscriber $user */
        $user = Subscriber::findOrFail($id);
        if ($user->hasVerifiedEmail()) {
            return view('auth/email-already-verified');
        }

        $user->markEmailAsVerified();

        return view('auth/email-verified');
    }
}
