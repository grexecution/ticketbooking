<?php

namespace App\Models;

use App\Models\SeatPlan\EventSeatPlanCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'order_id',
        'event_seat_plan_category_id',
        'voucher_id',
        'name',
        'voucher_name',
        'category_name',
        'discount',
        'price',
        'total',
        'is_refunded',
        'is_paid',
        'is_cancelled',
    ];

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function eventSeatPlanCategory() : BelongsTo
    {
        return $this->belongsTo(EventSeatPlanCategory::class);
    }
}
