<?php

namespace App\Models\User;

use App\Models\IdeHelperUser;
use App\Models\Tenant;
use App\Services\RoleService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'google2fa_enable',
        'google2fa_secret',
        'google2fa_authenticated',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * @return bool
     */
    public function isSuperUser() : bool
    {
        return $this->roles->filter(function (Role $role) {
            return $role->label === RoleService::ROLE_LABEL_SUPER_ADMIN;
        })->isNotEmpty();
    }

    public function permissions() : HasMany
    {
        return $this->hasMany(Permission::class);
    }

    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function tenant() : BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

}
