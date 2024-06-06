<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperStripeCallback
 */
class StripeCallback extends Model
{
    use HasFactory;

    protected $table = 'stripe_callbacks';

    protected $fillable = [
        'user_id',
        'event_id',
        'endpoint',
        'error',
        'payload',
        'response',
    ];

    protected $casts = [
        'payload' => 'json',
        'response' => 'json',
    ];
}
