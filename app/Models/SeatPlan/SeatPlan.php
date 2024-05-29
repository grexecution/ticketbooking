<?php

namespace App\Models\SeatPlan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeatPlan extends Model
{
    protected $table = 'seat_plans';

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
