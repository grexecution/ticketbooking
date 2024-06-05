<?php

namespace App\Models\SeatPlan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeatPlanCategory extends Model
{
    protected $table = 'seat_plan_categories';

    protected $fillable = [
        'seat_plan_id',
        'name',
        'price',
        'places',
        'rows',
        'seats',
        'aisles_after',
        'description',
    ];

    /**
     * @return BelongsTo
     */
    public function seatPlan() : BelongsTo
    {
        return $this->belongsTo(SeatPlan::class);
    }
}
