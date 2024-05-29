<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use App\Services\StripeConnectApi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StripeConnectController extends Controller
{
    protected StripeConnectApi $api;

    public function __construct(StripeConnectApi $api)
    {
        $this->api = $api;
        $this->middleware(['auth', '2fa']);
    }

    public function connectAccount(Request $request) : RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $accountId = $user->tenants?->stripe_account_id ?: $this->api->createAccount($user);
        $url = $this->api->createAccountLink($accountId);

        return redirect($url);
    }

    public function checkConnection(Request $request) : RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $connected = $this->api->checkConnection($user->tenant?->stripe_account_id);

        if (! $connected) {
            $user->tenant()->update(['stripe_connected' => false]);
            return redirect()->back()->with('error', 'Stripe is not connected!');
        }

        $user->tenant()->update(['stripe_connected' => true]);

        return redirect()->back()->with('success', 'Stripe successfully connected!');
    }

    public function handlePayment(Request $request)
    {
        $paymentIntent = $this->stripe->paymentIntents->create([
            'amount' => 1000, // Amount in cents
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'transfer_data' => [
                'destination' => $request->input('account_id'),
            ],
        ]);

        return response()->json($paymentIntent);
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );

            if ($event->type == 'payment_intent.succeeded') {
                // Handle the payment success
            }

            return response()->json(['status' => 'success']);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }
    }

}
