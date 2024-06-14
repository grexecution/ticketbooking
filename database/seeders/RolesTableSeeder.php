<?php

namespace Database\Seeders;

use App\Models\User\Permission;
use App\Models\User\Role;
use App\Services\RoleService;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * @var array|array[]
     */
    private array $rolesData = [
        ['title' => 'Super Admin', 'label' => RoleService::ROLE_LABEL_SUPER_ADMIN],
        ['title' => 'Admin', 'label' => RoleService::ROLE_LABEL_ADMIN],
    ];

    public function run() : void
    {
        foreach ($this->rolesData as $roleData) {
            /** @var Role $role */
            $role = Role::query()->firstOrCreate([
                'label' => $roleData['label'],
                'title' => $roleData['title'],
            ], $roleData);

            $allow = $this->getRolePermissions($role);
            $allow = Permission::query()->whereIn('title', $allow)->get();
            $role->permissions()->sync($allow);
        }
    }

    private function getRolePermissions(Role $role) : array
    {
        return match ($role->label) {
            RoleService::ROLE_LABEL_SUPER_ADMIN => [
                'dashboard_access',
                'user_access',
                'permission_access',
                'role_access',
                'user_access',
                'finance_access',
                'setting_access',
                'tenant_access',
                'event_access',
                'venue_access',
                'subscription_access',
                'discount_access',
                'voucher_access',
            ],
            RoleService::ROLE_LABEL_ADMIN => [
                'event_access',
                'finance_access',
                'setting_access',
                'venue_access',
                'subscription_access',
                'discount_access',
                'voucher_access',
            ],
        };
    }

}
