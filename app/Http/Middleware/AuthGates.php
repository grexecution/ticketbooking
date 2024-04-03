<?php

namespace App\Http\Middleware;

use App\Models\User\Role;
use App\Models\User\User;
use Closure;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) : mixed
    {
        if ($request->user()) {
            $roles = Role::with('permissions')->get();

            $permissionsData = [];
            foreach ($roles as $role) {
                foreach ($role->permissions as $permissions) {
                    $permissionsData[$permissions->title][] = $role->id;
                }
            }
            foreach ($permissionsData as $permissionsKey => $permissionsIds) {
                Gate::define($permissionsKey, function (User $user) use ($permissionsIds) {
                    $userRoleIds = $user->roles->pluck('id')->toArray();
                    return count(array_intersect($userRoleIds, $permissionsIds)) > 0;
                });
            }
        }

        return $next($request);
    }

}
