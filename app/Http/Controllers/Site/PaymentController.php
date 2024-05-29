<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\StripeCallback;
use App\Services\StripeConnectApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected StripeConnectApi $api;

    public function __construct(StripeConnectApi $api)
    {
        $this->api = $api;
//        $this->middleware(['auth']);
    }

    public function createCheckoutSession(Request $request) : JsonResponse
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'amount' => 'required|numeric',
        ]);

        $event = Event::findOrFail($request->input('event_id'));
        $accountId = $event->user?->tenant?->stripe_account_id;
        if (! $accountId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid event',
            ], 500);
        }

        $amount = (float) $request->input('amount') * 100; // Amount in cents
        $currency = $request->input('currency', 'eur');

        try {
            // Calculate 2% application fee
            $applicationFeeAmount = round($amount * 0.02);

            $payload = [
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => $currency,
                        'product_data' => [
                            'name' => $event->name,
                        ],
                        'unit_amount' => $amount,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('checkout.step3') . '?successfully=1',
                'cancel_url' => route('checkout.step3') . '?canceled=1',
                'payment_intent_data' => [
                    'application_fee_amount' => $applicationFeeAmount,
                    'transfer_data' => [
                        'destination' => $accountId,
                    ],
                ],
            ];

            // Create a Checkout Session
            $session = $this->api->getStripeClient()->checkout->sessions->create($payload);

            StripeCallback::query()->create([
                'user_id' => auth()?->id(),
                'event_id' => $event->id,
                'endpoint' => '/v1/checkout/sessions',
                'payload' => $payload,
                'response' => $session,
            ]);

            return response()->json([
                'status' => 'success',
                'sessionId' => $session->id,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function handleWebhook(Request $request) : JsonResponse
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe_connect.client_webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );

            switch ($event->type) {
                case 'payment_intent.canceled':
                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object;
                    // Todo set fail order
                    break;
                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object;
                    // Todo set success order
                    break;
                default:
                    info('Received unknown event type ' . $event->type);
            }

            StripeCallback::query()->create(['endpoint' => 'webhook', 'payload' => $payload, 'response' => ['status' => 'success']]);
            return response()->json(['status' => 'success']);

        } catch (\UnexpectedValueException $e) {
            StripeCallback::query()->create(['endpoint' => 'webhook', 'payload' => $payload, 'response' => ['error' => 'Invalid payload']]);
            return response()->json(['error' => 'Invalid payload'], 400);

        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            StripeCallback::query()->create(['endpoint' => 'webhook', 'payload' => $payload, 'response' => ['error' => 'Invalid signature']]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }
    }

//    public function handlePayment(Request $request) : JsonResponse
//    {
//        $request->validate([
//            'event_id' => 'required|exists:events,id',
//            'amount' => 'required|numeric',
//        ]);
//
//        try {
//            $paymentIntent = $this->api->handlePayment();
//
//            return response()->json([
//                'status' => 'success',
//                'paymentIntent' => $paymentIntent,
//            ]);
//        } catch (\Exception $e) {
//            return response()->json([
//                'status' => 'error',
//                'message' => $e->getMessage(),
//            ], 500);
//        }
//    }

}
