<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CustomerRoleSeeder extends Seeder
{
    public function run()
    {
        // Create Customer role if it doesn't exist
        $customerRole = Role::firstOrCreate(['name' => 'Customer']);
        
        // Create basic permissions for customers
        $permissions = [
            'view homepage',
            'view profile',
            'update profile',
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        // Assign permissions to Customer role
        $customerRole->syncPermissions($permissions);
    }
}
