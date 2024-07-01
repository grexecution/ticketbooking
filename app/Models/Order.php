<?php

namespace App\Models;

use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperOrder
 */
class Order extends Model
{
    protected $table = 'orders';

    const ORDER_TYPE_CUSTOMER = 'customer';
    const ORDER_TYPE_ADMIN = 'admin';

    protected $fillable = [
        'user_id',
        'event_id',
        'voucher_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'zip_code',
        'city',
        'is_subscribed',
        'order_type',
        'order_status',
        'order_date',
        'payment_method',
        'payment_intent_id',
        'subtotal',
        'discount',
        'vat',
        'total',
    ];

    protected $appends = [
        'wait_to_payment'
    ];

    public function scopeSucceeded($query)
    {
        return $query->where('order_status', 'succeeded');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function tickets() : HasMany
    {
        return $this->hasMany(Ticket::class);
    }
    public function getWaitToPaymentAttribute() : bool
    {
        $orderMoment = Carbon::createFromFormat('Y-m-d H:i:s', $this->order_date);
        $now = Carbon::now();
        $differenceInMinutes = $now->diffInMinutes($orderMoment);

        return $differenceInMinutes < 10;
    }

}
