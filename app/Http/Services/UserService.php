<?php

namespace App\Http\Services;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    public function getSuperAdmin(): User|Model
    {
        return User::query()->whereHas('roles', function (Builder $builder) {
            return $builder->where('label', 'super_admin');
        })->firstOrFail();
    }
}
