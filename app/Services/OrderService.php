<?php

namespace App\Services;

use App\Helpers\PriceHelper;
use App\Models\Order;
use App\Models\Voucher;

class OrderService
{

    public function createOrder(array $ticketsData, array $customerData, ? Voucher $voucher, ? float $discount) : Order
    {
        /** @var Order $order */
        $order = Order::query()->create([
            'user_id' => null,
            'event_id' => $ticketsData['event_id'] ?? $ticketsData['tickets'][0]['event_id'],
            'voucher_id' => $voucher?->id,
            'first_name' => $customerData['first_name'],
            'last_name' => $customerData['last_name'],
            'email' => $customerData['email'],
            'phone' => $customerData['phone'],
            'address' => $customerData['address'],
            'zip_code' => $customerData['zip_code'],
            'city' => $customerData['city'],
            'is_subscribed' => (bool) ($customerData['is_subscribed'] ?? false == 'on'),
            'order_type' => Order::ORDER_TYPE_CUSTOMER,
            'order_status' => 'new',
            'order_date' => now(),
            'payment_method' => 'card',
            'subtotal' => $ticketsData['amount'],
            'discount' => $discount,
            'vat' => null,
            'total' => $ticketsData['amount'],
        ]);

        if ($voucher) {
            $voucher->increment('used', 1);
        }

        foreach ($ticketsData['tickets'] as &$ticketData) {
            if (is_string($ticketData['price'])) {
                $ticketData['price'] = PriceHelper::fromFrontStrToFloat($ticketData['price']);
            }
            if (is_string($ticketData['total'])) {
                $ticketData['total'] = PriceHelper::fromFrontStrToFloat($ticketData['total']);
            }
        }

        foreach ($ticketsData['tickets'] as $ticket) {
            for ($i = 0; $i < (int) $ticket['count']; $i++) {
                $order->tickets()->create([
                    'event_seat_plan_category_id' => $ticket['categoryId'] ?? $ticket['id'], // $ticket['id'] for subscriptions
                    'voucher_id' => null,
                    'category_name' => $ticket['categoryName'],
                    'voucher_name' => null,
                    'name' => $ticket['name'],
                    'discount' => null,
                    'price' => $ticket['price'],
                    'row' => $ticket['row'] ?? null,
                    'seat' => $ticket['seat'] ?? null,
                    'total' => $ticket['total'],
                ]);
            }
        }

        return $order;
    }

}
