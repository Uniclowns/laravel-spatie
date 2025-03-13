<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $operator = Role::create(['name' => 'Operator']);

        $admin->givePermissionTo([
            'create-product',
            'edit-product',
            'delete-product',
            'create-user',
            'edit-user',
            'delete-user',
        ]);

        $operator->givePermissionTo([
            'create-product',
            'edit-product',
            'delete-product',
        ]);
    }
}
