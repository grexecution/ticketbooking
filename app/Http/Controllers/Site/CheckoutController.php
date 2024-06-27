<?php

namespace App\Http\Controllers\Site;

use App\Helpers\HashIdHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\CustomerDataRequest;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Order;
use App\Models\Voucher;
use App\Services\VoucherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function showStep1() : View
    {
        return view('site.checkout.step1');
    }

    public function showStep2(CustomerDataRequest $request) : View
    {
        $validatedData = $request->validated();
        Session::put('customer_data', $validatedData);

        return view('site.checkout.step2');
    }

    public function showStep3(Request $request) : View
    {
        $orderId = HashIdHelper::decodeId($request->order_id);

        $order = Order::query()
            ->with(['event.venue', 'tickets'])
            ->findOrFail($orderId);

        if ($request->canceled) {
            $order->update(['order_status' => 'cancelled']);
            $sessionId = Session::getId();
            Booking::query()->where('session_id', $sessionId)->delete();
        }

        return view('site.checkout.step3', compact('order'));
    }

    public function applyPromoCode(Request $request, VoucherService $voucherService) : JsonResponse
    {
        $request->validate([
            'promoCode' => 'required|exists:vouchers,name',
            'eventIds' => 'required|array',
            'total' => 'required|numeric|min:0',
        ]);

        /** @var Voucher $voucher */
        $voucher = Voucher::query()->where('name', $request->promoCode)->first();
        if ($voucher->max_usage > 0 && $voucher->used >= $voucher->max_usage) {
            return response()->json([
                'success' => false,
                'message' => 'That promo code cannot be used anymore.'
            ]);
        }

        $voucherEventIds = $voucher->events->pluck('id')->toArray();
        $voucherExceptEventIds = $voucher->eventsExcepts->pluck('id')->toArray();
        foreach ($request->eventIds as $eventId) {
            if (! in_array($eventId, $voucherEventIds)
                || ($voucherExceptEventIds && in_array($eventId, $voucherExceptEventIds))
            ) {
                $event = Event::find($eventId);
                return response()->json([
                    'success' => false,
                    'message' => "That promo code cannot be applied to event '{$event->name}'."
                ]);
            }
        }

        [$newTotal, $discount] = $voucherService->applyVoucher($voucher, $request->total);

        return response()->json([
            'success' => true,
            'newTotal' => $newTotal,
            'discount' => $discount,
        ]);
    }
}
