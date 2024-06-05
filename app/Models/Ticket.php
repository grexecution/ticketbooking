<?php

namespace App\Models;

use App\Models\SeatPlan\EventSeatPlanCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use InteractsWithMedia;

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
        'row',
        'seat',
        'total',
        'is_refunded',
        'is_paid',
        'is_cancelled',
        'qr_data',
    ];

    protected $appends = [
        'qr_url',
    ];

    public function getQrUrlAttribute() : ? string
    {
        return $this->getMedia('qr')->last()?->getFullUrl();
    }

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function eventSeatPlanCategory() : BelongsTo
    {
        return $this->belongsTo(EventSeatPlanCategory::class);
    }
}
