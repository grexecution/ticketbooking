<?php

namespace App\Models\SeatPlan;

use App\Models\Booking;
use App\Models\Event;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventSeatPlanCategory extends Model
{
    protected $table = 'event_seat_plan_categories';

    protected $fillable = [
        'parent_id',
        'seat_plan_id',
        'event_id',
        'subscription_id',
        'name',
        'price',
        'places',
        'rows',
        'seats',
        'aisles_after',
        'description',
    ];

    public function seatPlan() : BelongsTo
    {
        return $this->belongsTo(SeatPlan::class);
    }

    public function subscription() : BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function event() : BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function bookings() : HasMany
    {
        return $this->hasMany(Booking::class, 'event_seat_plan_category_id', 'id');
    }
}
