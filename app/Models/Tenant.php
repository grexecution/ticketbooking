<?php

namespace App\Models;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'company',
        'stripe_key',
        'stripe_secret',
        'stripe_fee',
    ];

    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    public function venues()
    {
        return collect();
    }

    public function events()
    {
        return collect();
    }
}
