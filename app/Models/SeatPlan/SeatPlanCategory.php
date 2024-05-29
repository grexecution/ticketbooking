<?php

namespace App\Models\SeatPlan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeatPlanCategory extends Model
{
    protected $table = 'seat_plan_categories';

    protected $fillable = [
        'saat_plan_id',
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
}
