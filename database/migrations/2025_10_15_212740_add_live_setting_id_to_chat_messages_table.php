<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            // Add user_id if not exists
            if (!Schema::hasColumn('chat_messages', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
            }
            
            // Add live_setting_id after message column (which definitely exists)
            $table->foreignId('live_setting_id')->nullable()->after('message')->constrained('live_settings')->onDelete('set null');
            $table->index('live_setting_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            if (Schema::hasColumn('chat_messages', 'live_setting_id')) {
                $table->dropForeign(['live_setting_id']);
                $table->dropIndex(['live_setting_id']);
                $table->dropColumn('live_setting_id');
            }
            
            if (Schema::hasColumn('chat_messages', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
