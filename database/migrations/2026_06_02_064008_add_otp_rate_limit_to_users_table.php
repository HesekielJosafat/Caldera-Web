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
        if (!Schema::hasColumn('users', 'otp_send_count')) {
            $table->integer('otp_send_count')->default(0);
            }
        if (!Schema::hasColumn('users', 'otp_send_window_start')) {
            $table->timestamp('otp_send_window_start')->nullable();
            }
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['otp_send_count', 'otp_send_window_start']);
        });
    }

};
