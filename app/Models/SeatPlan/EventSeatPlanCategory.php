<?php

namespace App\Models\SeatPlan;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventSeatPlanCategory extends Model
{
    protected $table = 'event_seat_plan_categories';

    protected $fillable = [
        'seat_plan_id',
        'event_id',
        'name',
        'price',
        'places',
        'description',
    ];

    /**
     * @return BelongsTo
     */
    public function seatPlan() : BelongsTo
    {
        return $this->belongsTo(SeatPlan::class);
    }

    /**
     * @return BelongsTo
     */
    public function event() : BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
