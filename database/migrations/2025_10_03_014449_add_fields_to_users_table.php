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
        Schema::table('users', function (Blueprint $table) {
            $table->string('account')->nullable()->after('email');
            $table->string('bank_account')->nullable()->after('account');
            $table->string('platform')->nullable()->after('bank_account');
            $table->enum('user_type', ['admin_created', 'external_login'])->default('admin_created')->after('platform');
            $table->json('api_response')->nullable()->after('user_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['account', 'bank_account', 'platform', 'user_type', 'api_response']);
        });
    }
};
