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
            // Rename play_url to play_url_flv
            $table->renameColumn('play_url', 'play_url_flv');
        });

        Schema::table('live_settings', function (Blueprint $table) {
            // Add new play_url_m3u8 field after play_url_flv
            $table->string('play_url_m3u8')->nullable()->after('play_url_flv');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('live_settings', function (Blueprint $table) {
            // Remove play_url_m3u8
            $table->dropColumn('play_url_m3u8');
        });

        Schema::table('live_settings', function (Blueprint $table) {
            // Rename back to play_url
            $table->renameColumn('play_url_flv', 'play_url');
        });
    }
};
