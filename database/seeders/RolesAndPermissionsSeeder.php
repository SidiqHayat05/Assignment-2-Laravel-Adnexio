<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'), 
        ]);

        User::factory()->create([
            'name' => 'Staff',
            'email' => 'staff@test.com',
            'password' => Hash::make('password123'), 
        ]);

        User::factory()->create([
            'name' => 'Viewer',
            'email' => 'viewer@test.com',
            'password' => Hash::make('password123'), 
        ]);

        // Create permissions
        $permissions = [
            'products-view',
            'products-create',
            'products-update',
            'products-delete'
        ];

        $roles = [
            'admin',
            'staff',
            'viewer'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        $staffRole = Role::firstOrCreate(['name' => 'Staff']);
        $staffRole->givePermissionTo(['products-view', 'products-create', 'products-update']);

        $viewerRole = Role::firstOrCreate(['name' => 'Viewer']);
        $viewerRole->givePermissionTo(['products-view']);

        // Assign first user as admin (optional)
        $user = User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
