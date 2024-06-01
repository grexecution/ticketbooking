<?php

namespace App\Models;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';

    const ORDER_TYPE_CUSTOMER = 'customer';
    const ORDER_TYPE_ADMIN = 'admin';

    protected $fillable = [
        'user_id',
        'event_id',
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
        'subtotal',
        'discount',
        'vat',
        'total',
    ];

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
}
