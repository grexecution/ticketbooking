<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Ticket;
use App\Services\StripeConnectApi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order) : View
    {
        $order->load(['event', 'tickets']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Display the specified resource.
     */
    public function showInvoice(string $orderId) : View
    {
        $order = Order::query()->with(['tickets'])->findOrFail($orderId);

        return view('admin.orders.invoice', compact('order'));
    }

    public function showTickets(string $orderId) : View
    {
        $order = Order::query()->with(['tickets', 'event.venue'])->findOrFail($orderId);
        abort_if($order->order_status !== 'succeeded', 403);

        return  view('admin.orders.tickets', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cancel(Request $request, int $ticketId)
    {
        /** @var Ticket $ticket */
        $ticket = Ticket::query()->findOrFail($ticketId);
        if ($ticket->is_cancelled) {
            return redirect()->back()->with('error', 'Ticket already cancelled!');
        }

        $ticket->update([
            'is_cancelled' => true,
        ]);

        return redirect()->back()->with('success', 'Operation successful!');
    }

    public function cancelAndRefund(Request $request, int $orderID)
    {
        $order = Order::query()->findOrFail($orderID);
        if (! $order->order_type || $order->order_status !== 'succeeded') {
            return redirect()->back()->with('error', 'Order cannot be cancelled!');
        }
        if (! $order->payment_intent_id) {
            return redirect()->back()->with('error', 'Invalid Stripe payment intent!');
        }

        $paymentIntentId = $order->payment_intent_id;
        $stripeApi = app(StripeConnectApi::class);

        try {
            $refund = $stripeApi->refundPayment($paymentIntentId);
            if ($refund->status === 'succeeded') {
                $order->update([
                    'order_status' => 'refunded',
                ]);

                $order->tickets->each(function (Ticket $ticket) {
                    $ticket->update([
                        'is_refunded' => true,
                        'is_cancelled' => true,
                    ]);
                });
            }

            return redirect()->back()->with('success', 'Operation successful!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
