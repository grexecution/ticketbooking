<?php

namespace App\Models;

use App\Models\SeatPlan\EventSeatPlanCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperCheckin
 */
class Checkin extends Model
{
    protected $fillable = [
        'event_id',
        'ticket_id',
        'event_seat_plan_category_id',
        'category',
        'seat',
        'row',
    ];

    public function event() : BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket() : BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function seatPlanCategory() : BelongsTo
    {
        return $this->belongsTo(EventSeatPlanCategory::class);
    }
}
