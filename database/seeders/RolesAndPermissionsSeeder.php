<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'products-view',
            'products-create',
            'products-update',
            'products-delete'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $staffRole->givePermissionTo(['products-view', 'products-create', 'products-update']);

        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);
        $viewerRole->givePermissionTo(['products-view']);

        // Assign first user as admin (optional)
        $user = User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
