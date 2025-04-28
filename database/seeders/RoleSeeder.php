<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'client']);

        // $permission_create_role = Permission::create(['name' => 'create_role']);
        // $permission_edit_role = Permission::create(['name' => 'edit_role']);
        // $permission_delete_role = Permission::create(['name' => 'delete_role']);
        // $permission_view_role = Permission::create(['name' => 'view_role']);

        // $permission_create_user = Permission::create(['name' => 'create_user']);
        // $permission_edit_user = Permission::create(['name' => 'edit_user']);
        // $permission_delete_user = Permission::create(['name' => 'delete_user']);
        // $permission_view_user = Permission::create(['name' => 'view_user']);

        // $permission_create_product = Permission::create(['name' => 'create_product']);
        // $permission_edit_product = Permission::create(['name' => 'edit_product']);
        // $permission_delete_product = Permission::create(['name' => 'delete_product']);
        // $permission_view_product = Permission::create(['name' => 'view_product']);

        // $permission_create_order = Permission::create(['name' => 'create_order']);
        // $permission_edit_order = Permission::create(['name' => 'edit_order']);
        // $permission_delete_order = Permission::create(['name' => 'delete_order']);
        // $permission_view_order = Permission::create(['name' => 'view_order']);
        // $permission_cancel_order = Permission::create(['name' => 'cancel_order']);

        // $permission_create_category = Permission::create(['name' => 'create_category']);
        // $permission_edit_category = Permission::create(['name' => 'edit_category']);
        // $permission_delete_category = Permission::create(['name' => 'delete_category']);
        // $permission_view_category = Permission::create(['name' => 'view_category']);


        // $permission_admin = [
        //     $permission_edit_user,
        //     $permission_view_user,

        //     $permission_create_product,
        //     $permission_edit_product,
        //     $permission_delete_product,
        //     $permission_view_product,

        //     $permission_edit_order,
        //     $permission_view_order,
        //     $permission_cancel_order,

        //     $permission_create_category,
        //     $permission_edit_category,
        //     $permission_delete_category,
        //     $permission_view_category
        // ];
        // $permission_user = [
        //     $permission_create_order,
        //     $permission_edit_order,
        //     $permission_delete_order,
        //     $permission_view_order,
        //     $permission_cancel_order,

        //     $permission_view_product,
        //     $permission_view_category
        // ];

    }
}
