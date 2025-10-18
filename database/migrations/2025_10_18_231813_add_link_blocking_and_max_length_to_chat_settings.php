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
        // Insert new chat settings
        DB::table('chat_settings')->insert([
            [
                'key' => 'block_links_enabled',
                'value' => '1',
                'description' => 'Chặn gửi link từ người dùng (Admin và Live Staff không bị chặn)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'max_message_length',
                'value' => '200',
                'description' => 'Số ký tự tối đa cho mỗi tin nhắn (Admin và Live Staff không bị giới hạn)',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('chat_settings')->whereIn('key', [
            'block_links_enabled',
            'max_message_length'
        ])->delete();
    }
};
