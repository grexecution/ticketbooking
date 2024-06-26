<?php

namespace App\Services;

use App\Helpers\PriceHelper;
use App\Models\Order;
use App\Models\Voucher;

class OrderService
{
    const TAX_PERCENTAGE = 13;

    public function createOrder(array $ticketsData, array $customerData, ? Voucher $voucher, ? float $discount) : Order
    {
        $amount = $ticketsData['amountDiscount'] ?: $ticketsData['amount'];
        $taxRate = self::TAX_PERCENTAGE / 100;
        $taxes = round($amount * $taxRate, 2);
        $amountWithTaxes = round($amount + $taxes, 2);

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
            'subtotal' => $amount,
            'discount' => $discount,
            'vat' => $taxes,
            'total' => $amount,
        ]);

        if ($voucher) {
            $voucher->increment('used', 1);
        }

        foreach ($ticketsData['tickets'] as &$ticketData) {
            if (is_string($ticketData['price'])) {
                $ticketData['price'] = PriceHelper::fromStrToFloat($ticketData['price']);
            }
            if (is_string($ticketData['total'])) {
                $ticketData['total'] = PriceHelper::fromStrToFloat($ticketData['total']);
            }
        }

        $ticketDiscount = 0;
        if ($discount) {
            $ticketDiscount = max(0, round($discount / count($ticketsData['tickets']), 2));
        }

        foreach ($ticketsData['tickets'] as $ticket) {
            for ($i = 0; $i < (int) $ticket['count']; $i++) {
                $order->tickets()->create([
                    'event_seat_plan_category_id' => $ticket['categoryId'] ?? $ticket['id'], // $ticket['id'] for subscriptions
                    'voucher_id' => null,
                    'category_name' => $ticket['categoryName'],
                    'voucher_name' => null,
                    'name' => $ticket['name'],
                    'discount' => $ticketDiscount,
                    'price' => $price = max(0.1, round($ticket['price'] - $ticketDiscount, 2)),
                    'row' => $ticket['row'] ?? null,
                    'seat' => $ticket['seat'] ?? null,
                    'total' => $price,
                ]);
            }
        }

        return $order;
    }

}
