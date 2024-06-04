<?php

namespace App\Models;

use App\Models\SeatPlan\EventSeatPlanCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'event_id',
        'event_seat_plan_category_id',
        'session_id',
        'seat',
        'row',
        'expires_at',
    ];

    public function event() : BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function seatPlanCategory() : BelongsTo
    {
        return $this->belongsTo(EventSeatPlanCategory::class);
    }
}
