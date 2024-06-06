<?php

namespace App\Models\SeatPlan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperSeatPlan
 */
class SeatPlan extends Model
{
    protected $table = 'seat_plans';

    const SEAT_PLAN_CUSTOM_ID = 1;

    protected $fillable = [
        'id',
        'name',
        'is_active',
        'is_custom',
        'places',
    ];

    public function seatPlanCategories() : HasMany
    {
        return $this->hasMany(SeatPlanCategory::class);
    }
}
