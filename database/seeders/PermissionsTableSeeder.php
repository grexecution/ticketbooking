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
        'role_access', 'role_edit', 'role_show',
        'user_access', 'user_create', 'user_edit', 'user_show', 'user_delete',
        'event_access', 'event_create', 'event_edit', 'event_show', 'event_delete',
        'finance_access',
        'setting_access',
        'tenant_access',
    ];

    public function run() : void
    {
        $insertData = array_map(static fn($row) => ['title' => $row], $this->permissions);

        Permission::query()->insertOrIgnore($insertData);
    }
}
