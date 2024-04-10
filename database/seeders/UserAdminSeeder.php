<?php

namespace Database\Seeders;

use App\Models\User\Role;
use App\Models\User\User;
use App\Services\RoleService;
use Hash;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin
        $user = User::query()->create([
            'name'           => 'Super Admin',
            'email'          => 'super@admin.com',
            'first_name'     => 'Super',
            'last_name'      => 'Admin',
            'password'       => Hash::make('admin'),
            'google2fa_enable' => true,
            'google2fa_secret' => \Google2FA::generateSecretKey(),
        ]);
        $role = Role::query()->where('label', RoleService::ROLE_LABEL_SUPER_ADMIN)->firstOrFail();
        $user->roles()->sync($role->id);

        // Create admin
        $user = User::query()->create([
            'name'           => 'Admin',
            'email'          => 'admin@admin.com',
            'first_name'     => 'Admin',
            'last_name'      => '',
            'password'       => Hash::make('admin'),
            'google2fa_enable' => true,
            'google2fa_secret' => \Google2FA::generateSecretKey(),
        ]);
        $role = Role::query()->where('label', RoleService::ROLE_LABEL_ADMIN)->firstOrFail();
        $user->roles()->sync($role->id);
    }
}
