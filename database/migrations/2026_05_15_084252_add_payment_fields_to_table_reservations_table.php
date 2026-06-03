<?php
// database/migrations/2024_01_15_000001_add_payment_fields_to_table_reservations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('table_reservations', function (Blueprint $table) {
            // Cek apakah kolom sudah ada sebelum menambah
            if (!Schema::hasColumn('table_reservations', 'down_payment')) {
                $table->decimal('down_payment', 10, 2)->default(0)->after('payment_status');
            }
            
            if (!Schema::hasColumn('table_reservations', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('down_payment');
            }
            
            if (!Schema::hasColumn('table_reservations', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('transaction_id');
            }
            
            if (!Schema::hasColumn('table_reservations', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('paid_at');
            }
        });
        
        // Update enum payment_status untuk menambah nilai 'waiting_payment' dan 'payment_verified'
        // Ini untuk database PostgreSQL
        DB::statement("ALTER TABLE table_reservations DROP CONSTRAINT IF EXISTS table_reservations_payment_status_check");
        DB::statement("ALTER TABLE table_reservations ADD CONSTRAINT table_reservations_payment_status_check CHECK (payment_status IN ('unpaid', 'partial', 'paid', 'waiting_payment', 'payment_verified'))");
    }

    public function down()
    {
        Schema::table('table_reservations', function (Blueprint $table) {
            $table->dropColumn(['down_payment', 'transaction_id', 'paid_at', 'payment_proof']);
        });
        
        // Kembalikan constraint lama
        DB::statement("ALTER TABLE table_reservations DROP CONSTRAINT IF EXISTS table_reservations_payment_status_check");
        DB::statement("ALTER TABLE table_reservations ADD CONSTRAINT table_reservations_payment_status_check CHECK (payment_status IN ('unpaid', 'partial', 'paid'))");
    }
};