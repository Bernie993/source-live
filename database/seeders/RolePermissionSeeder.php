<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage-live-settings',
            'view-live-settings', 
            'manage-users',
            'manage-keywords',
            'view-live-link',
            'manage-chat'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->syncPermissions([
            'manage-live-settings',
            'view-live-settings',
            'manage-users',
            'manage-keywords',
            'manage-chat'
        ]);

        $liveStaffRole = Role::firstOrCreate(['name' => 'Nhân viên Live']);
        $liveStaffRole->syncPermissions([
            'view-live-link',
            'manage-chat'
        ]);

        $cskhRole = Role::firstOrCreate(['name' => 'CSKH']);
        $cskhRole->syncPermissions([
            'manage-keywords'
        ]);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'user_type' => 'admin_created'
            ]
        );
        $admin->assignRole('Admin');

        // Create sample live staff
        $liveStaff = User::firstOrCreate(
            ['email' => 'live@example.com'],
            [
                'name' => 'Live Staff',
                'password' => Hash::make('password'),
                'user_type' => 'admin_created'
            ]
        );
        $liveStaff->assignRole('Nhân viên Live');

        // Create sample CSKH
        $cskh = User::firstOrCreate(
            ['email' => 'cskh@example.com'],
            [
                'name' => 'CSKH Staff',
                'password' => Hash::make('password'),
                'user_type' => 'admin_created'
            ]
        );
        $cskh->assignRole('CSKH');
    }
}
