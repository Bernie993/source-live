<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Update "Nhân viên Live" role permissions
        $liveStaffRole = Role::where('name', 'Nhân viên Live')->first();
        if ($liveStaffRole) {
            // Remove manage-keywords permission
            $liveStaffRole->revokePermissionTo('manage-keywords');
            
            // Add manage-chat permission if not exists
            $liveStaffRole->givePermissionTo('manage-chat');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Restore original permissions
        $liveStaffRole = Role::where('name', 'Nhân viên Live')->first();
        if ($liveStaffRole) {
            $liveStaffRole->revokePermissionTo('manage-chat');
            $liveStaffRole->givePermissionTo('manage-keywords');
        }
    }
};


