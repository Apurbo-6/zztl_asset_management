<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // Dashboard
            'dashboard.view',

            // Purchases
            'purchases.view',
            'purchases.create',
            'purchases.update',
            'purchases.delete',

            // Assets
            'assets.view',
            'assets.create',
            'assets.update',
            'assets.delete',

            // Categories
            'categories.view',
            'categories.create',
            'categories.update',
            'categories.delete',

            // Suppliers
            'suppliers.view',
            'suppliers.create',
            'suppliers.update',
            'suppliers.delete',

            // Departments
            'departments.view',
            'departments.create',
            'departments.update',
            'departments.delete',

            // Asset Assignments
            'asset_assignments.view',
            'asset_assignments.create',
            'asset_assignments.update',
            'asset_assignments.return',

            // Administration
            'users.manage',
            'roles.manage',
            'activity_logs.view',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        // Super Admin Role
        $admin = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        // Give all permissions to Super Admin
        $admin->syncPermissions(Permission::all());

        // Default Admin User
        $user = User::firstOrCreate(
            [
                'email' => 'admin@zztl.local',
            ],
            [
                'name' => 'ZZTL Administrator',
                'password' => 'ChangeMe@12345',
                'is_active' => true,
            ]
        );

        $user->assignRole($admin);
    }
}
