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
        Schema::create('chat_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('Setting key');
            $table->text('value')->nullable()->comment('Setting value');
            $table->string('description')->nullable()->comment('Setting description');
            $table->timestamps();
        });

        // Insert default settings
        DB::table('chat_settings')->insert([
            [
                'key' => 'message_throttle_seconds',
                'value' => '10',
                'description' => 'Thời gian tối thiểu giữa các tin nhắn (giây)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'throttle_enabled',
                'value' => '1',
                'description' => 'Bật/tắt giới hạn thời gian gửi tin nhắn',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_settings');
    }
};
