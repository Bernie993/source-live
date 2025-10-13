<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix null timestamps in chat_messages table
        DB::table('chat_messages')
            ->whereNull('created_at')
            ->update(['created_at' => now()]);
            
        DB::table('chat_messages')
            ->whereNull('updated_at')
            ->update(['updated_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this migration
    }
};