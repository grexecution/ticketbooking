<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
