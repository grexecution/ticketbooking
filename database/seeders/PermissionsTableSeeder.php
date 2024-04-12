<?php

namespace Database\Seeders;

use App\Models\User\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * @var array|string[]
     */
    private array $permissions = [
        'dashboard_access',
        'user_access',
        'permission_access',
        'role_access',
        'user_access',
        'event_access',
        'finance_access',
        'setting_access',
        'tenant_access',
        'venue_access',
        'subscription_access',
        'discount_access',
        'voucher_access',
    ];

    public function run() : void
    {
        $insertData = array_map(static fn($row) => ['title' => $row], $this->permissions);

        Permission::query()->insertOrIgnore($insertData);
    }
}
