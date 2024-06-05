<?php

namespace App\Http\Controllers\Site;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\StripeCallback;
use App\Models\Ticket;
use App\Services\OrderService;
use App\Services\QRCodeService;
use App\Services\StripeConnectApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function Laravel\Prompts\error;

class PaymentController extends Controller
{
    protected StripeConnectApi $api;

    public function __construct(StripeConnectApi $api)
    {
        $this->api = $api;
    }

    public function createCheckoutSession(Request $request) : JsonResponse
    {
        $ticketsData = $request->validate([
            'event_id' => 'required|exists:events,id',
            'tickets' => 'required|array',
            'amount' => 'required|numeric',
        ]);

        $event = Event::findOrFail($request->input('event_id'));
        $accountId = $event->user?->tenant?->stripe_account_id;
        if (! $accountId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid stripe_account_id',
            ], 500);
        }

        $order = app(OrderService::class)->createOrder($ticketsData, Session::get('customer_data'));

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
                'metadata' => [
                    'event_id' => $event->id,
                    'order_id' => $order->id,
                ],
                'mode' => 'payment',
                'success_url' => route('checkout.step3') . '?successfully=1&order_id=' . $order->id,
                'cancel_url' => route('checkout.step3') . '?canceled=1&order_id=' . $order->id,
                'payment_intent_data' => [
                    'application_fee_amount' => $applicationFeeAmount,
                    'transfer_data' => [
                        'destination' => $accountId,
                    ],
                    'metadata' => [
                        'event_id' => $event->id,
                        'order_id' => $order->id,
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

            Session::forget('customer_data');

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
                    $this->handlePaymentIntentFailed($event->data->object);
                    break;
                case 'payment_intent.succeeded':
                    $this->handlePaymentIntentSucceeded($event->data->object);
                    break;
                default:
                    info('Received unknown event type ' . $event->type);
            }

            StripeCallback::query()->create(['endpoint' => 'webhook', 'payload' => ['input' => $request->all(), 'event' => $event ?? null], 'response' => ['status' => 'success']]);
            return response()->json(['status' => 'success']);

        } catch (\UnexpectedValueException $e) {
            StripeCallback::query()->create(['endpoint' => 'webhook', 'payload' => ['input' => $request->all(), 'event' => $event ?? null], 'response' => ['error' => 'Invalid payload']]);
            return response()->json(['error' => 'Invalid payload'], 400);

        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            StripeCallback::query()->create(['endpoint' => 'webhook', 'payload' => ['input' => $request->all(), 'event' => $event ?? null], 'response' => ['error' => 'Invalid signature']]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }
    }

    protected function handlePaymentIntentSucceeded($paymentIntent, QRCodeService $QRCodeService) : void
    {
        $orderId = $paymentIntent->metadata?->order_id;
        $order = Order::query()->find($orderId)->first();

        if ($order) {
            $order->update([
                'order_status' => $paymentIntent->status,
                'is_paid' => true,
            ]);
        }

        foreach ($order->tickets as $ticket) {
            try {
                /** @var Ticket $ticket */
                foreach ($order->tickets as $t) {
                    $qrData = implode('_', [
                        $order->id,
                        $order->event->id,
                        $t->id,
                    ]); // Example of data: 6_6_14
                    $ticket->update(['qr_data' => $qrData]);
                    $tmpFileName = $QRCodeService->createQR($qrData);
                    MediaHelper::handleMedia($t, 'qr', $tmpFileName);
                    info("QR created: {$t->qr_url}");
                }

            } catch (\Exception $e) {
                \Log::error("Error create a QR to ticket#{$ticket->id}: " . $e->getMessage());
            }
        }

        info('Payment intent succeeded for order: ' . ($order ? $order->id : 'Order not found'));
    }

    protected function handlePaymentIntentFailed($paymentIntent) : void
    {
        $orderId = $paymentIntent->metadata?->order_id;
        $order = Order::query()->find($orderId)->first();

        if ($order) {
            $order->update([
                'order_status' => $paymentIntent->status,
                'is_paid' => false,
            ]);
        }

        info('Payment intent failed for order: ' . ($order ? $order->id : 'Order not found'));
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
