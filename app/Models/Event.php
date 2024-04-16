<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperEvent
 */
class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'venue_id',
        'name',
        'artist',
        'price',
        'active',
        'status',
        'start_date',
        'start_time',
        'doors_open_time',
        'short_desc',
        'description',
    ];

    protected $casts = [
        'active' => 'boolean',
        'start_date' => 'datetime',
        'start_time' => 'datetime',
        'doors_open_time' => 'datetime',
    ];

    public function vouchers() : BelongsToMany
    {
        return $this->belongsToMany(Voucher::class, 'event_voucher', 'event_id', 'voucher_id');
    }

    public function vouchersExcepts() : BelongsToMany
    {
        return $this->belongsToMany(Voucher::class, 'event_voucher_excepts', 'event_id', 'voucher_id');
    }
}
