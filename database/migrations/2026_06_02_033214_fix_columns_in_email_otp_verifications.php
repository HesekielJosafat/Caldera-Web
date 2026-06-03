<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('email_otp_verifications', function (Blueprint $table) {
            // Tambahkan kolom 'used' untuk memperbaiki error SQL dari API
            if (!Schema::hasColumn('email_otp_verifications', 'used')) {
                $table->boolean('used')->default(false);
            }
            
            // Tambahkan juga 'is_used' untuk jaga-jaga karena Web Controller Anda memakainya
            if (!Schema::hasColumn('email_otp_verifications', 'is_used')) {
                $table->boolean('is_used')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('email_otp_verifications', function (Blueprint $table) {
            if (Schema::hasColumn('email_otp_verifications', 'used')) {
                $table->dropColumn('used');
            }
            if (Schema::hasColumn('email_otp_verifications', 'is_used')) {
                $table->dropColumn('is_used');
            }
        });
    }
};