<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'global_admin' => Role::create(['name' => 'global_admin', 'guard_name' => 'api']),
            'company_admin' => Role::create(['name' => 'company_admin', 'guard_name' => 'api']),
            'stock_manager' => Role::create(['name' => 'stock_manager', 'guard_name' => 'api']),
            'stock_operator' => Role::create(['name' => 'stock_operator', 'guard_name' => 'api']),
        ];

        $systemPermissions = [
            'change_global_settings' =>Permission::create(['name' => 'change_global_settings', 'guard_name' => 'api']),
            'change_plans_price' => Permission::create(['name' => 'change_plans_price', 'guard_name' => 'api']),
            'change_roles' => Permission::create(['name' => 'change_roles', 'guard_name' => 'api']),
        ];

        $stockPermissions = [
            'create_item' => Permission::create(['name' => 'create_item', 'guard_name' => 'api']),
            'view_item' => Permission::create(['name' => 'view_item', 'guard_name' => 'api']),
            'update_item' => Permission::create(['name' => 'update_item', 'guard_name' => 'api']),
            'delete_item' => Permission::create(['name' => 'delete_item', 'guard_name' => 'api']),
            'restore_item' => Permission::create(['name' => 'restore_item', 'guard_name' => 'api']),
            'replenish_stock' => Permission::create(['name' => 'replenish_stock', 'guard_name' => 'api']),
            'remove_from_stock' => Permission::create(['name' => 'remove_from_stock', 'guard_name' => 'api']),
        ];

        $usersPermissions = [
            'create_user' => Permission::create(['name' => 'create_user', 'guard_name' => 'api']),
            'view_user' => Permission::create(['name' => 'view_user', 'guard_name' => 'api']),
            'update_user' => Permission::create(['name' => 'update_user', 'guard_name' => 'api']),
            'delete_user' => Permission::create(['name' => 'delete_user', 'guard_name' => 'api']),
            'restore_user' => Permission::create(['name' => 'restore_user', 'guard_name' => 'api']),
        ];

        $roles['global_admin']->syncPermissions([
            $systemPermissions['change_global_settings'],
            $systemPermissions['change_plans_price'],
            $systemPermissions['change_roles'],

            $stockPermissions['create_item'],
            $stockPermissions['view_item'],
            $stockPermissions['update_item'],
            $stockPermissions['delete_item'],
            $stockPermissions['restore_item'],
            $stockPermissions['replenish_stock'],
            $stockPermissions['remove_from_stock'],

            $usersPermissions['create_user'],
            $usersPermissions['view_user'],
            $usersPermissions['update_user'],
            $usersPermissions['delete_user'],
        ]);

        $roles['company_admin']->syncPermissions([
            $systemPermissions['change_roles'],

            $stockPermissions['create_item'],
            $stockPermissions['view_item'],
            $stockPermissions['update_item'],
            $stockPermissions['delete_item'],
            $stockPermissions['restore_item'],
            $stockPermissions['replenish_stock'],
            $stockPermissions['remove_from_stock'],

            $usersPermissions['create_user'],
            $usersPermissions['view_user'],
            $usersPermissions['update_user'],
            $usersPermissions['delete_user'],
            $usersPermissions['restore_user'],
        ]);

        $roles['stock_manager']->syncPermissions([
            $stockPermissions['create_item'],
            $stockPermissions['view_item'],
            $stockPermissions['update_item'],
            $stockPermissions['delete_item'],
            $stockPermissions['restore_item'],
            $stockPermissions['replenish_stock'],
            $stockPermissions['remove_from_stock'],
        ]);

        $roles['stock_operator']->syncPermissions([
            $stockPermissions['view_item'],
            $stockPermissions['replenish_stock'],
            $stockPermissions['remove_from_stock'],
        ]);
    }
}
