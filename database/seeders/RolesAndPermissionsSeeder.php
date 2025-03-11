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
        // Define permissions
        $permissions = [
            'view_dashboard', 'view_products', 'create_products', 'edit_products', 'delete_products',
            'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
            'view_users', 'create_users', 'edit_users', 'delete_users',
            'manage_roles', 'manage_permissions', 'receive_stock_alerts'
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles and their permissions
        $roles = [
            'super_admin' => $permissions,
            'product_manager' => [
                'view_dashboard', 'view_products', 'create_products', 'edit_products', 'delete_products',
                'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
                'receive_stock_alerts'
            ],
            'user_manager' => [
                'view_dashboard', 'view_users', 'create_users', 'edit_users', 'delete_users'
            ]
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        $user = User::first();
        $user->assignRole('super_admin');

    }
}
