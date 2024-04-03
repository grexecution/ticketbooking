<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Permission
 *
 * @mixin IdeHelperPermission
 */
class Permission extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = ['title'];

}
