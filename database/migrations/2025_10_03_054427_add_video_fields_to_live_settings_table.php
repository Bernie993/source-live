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
        Schema::table('live_settings', function (Blueprint $table) {
            $table->string('default_video_url')->nullable()->after('play_url');
            $table->string('live_title')->nullable()->after('default_video_url');
            $table->text('live_description')->nullable()->after('live_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('live_settings', function (Blueprint $table) {
            $table->dropColumn(['default_video_url', 'live_title', 'live_description']);
        });
    }
};
