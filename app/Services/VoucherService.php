<?php

namespace App\Services;

use App\Models\Voucher;

class VoucherService
{

    public function applyVoucher(Voucher $voucher, float $total) : array
    {
        $newTotal = match ($voucher->type) {
            'percentage' => max(0, $total - ($total * ($voucher->percentage / 100))),
            'fixed' => max(0, $total - $voucher->fixed)
        };

        $discount = round($total - $newTotal, 2);

        return [round($newTotal, 2), $discount];
    }

}
