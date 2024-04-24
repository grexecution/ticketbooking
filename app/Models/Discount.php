<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperDiscount
 */
class Discount extends Model
{
    protected $table = 'discounts';

    protected $fillable = [
        'name',
        'description',
        'type',
        'percentage',
        'fixed',
    ];

    public function events() : BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_discount', 'discount_id', 'event_id');
    }
}
