<?php
// database/migrations/xxxx_add_otp_verified_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'otp_verified')) {
                $table->boolean('otp_verified')
                      ->default(false)
                      ->after('is_active');
            }
        });

        // ⚠️ PENTING: User lama langsung set verified=true
        // supaya mereka tidak ter-lock saat deployment
        DB::table('users')
            ->whereNotNull('email_verified_at')
            ->update(['otp_verified' => true]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'otp_verified')) {
                $table->dropColumn('otp_verified');
            }
        });
    }
};