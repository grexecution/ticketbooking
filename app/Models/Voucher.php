<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperVoucher
 */
class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $fillable = [
        'name',
        'description',
        'type',
        'percentage',
        'fixed',
        'max_usage',
        'expired_at',
    ];

    public function events() : BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_voucher', 'voucher_id', 'event_id');
    }

    public function eventsExcepts() : BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_voucher_excepts', 'voucher_id', 'event_id');
    }
}
