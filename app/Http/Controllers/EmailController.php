<?php

namespace App\Http\Controllers;

use App\Events\Subscribed;
use App\Http\Requests\StoreSubscriberRequest;
use App\Models\Subscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function subscribe(StoreSubscriberRequest $request): JsonResponse
    {
        $email = $request->get('email');

        $subscriber = Subscriber::where('email', $email)->first();

        if ($subscriber) {
            return $this->errorResponse(409);
        }

        $subscriber = Subscriber::create([
            'email' => $email,
        ]);

        event(new Subscribed($subscriber));

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
