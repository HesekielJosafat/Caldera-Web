<?php
// database/migrations/2024_01_18_000010_update_pool_tickets_payment_status_constraint.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Untuk PostgreSQL
        DB::statement("ALTER TABLE pool_tickets DROP CONSTRAINT IF EXISTS pool_tickets_payment_status_check");
        DB::statement("ALTER TABLE pool_tickets ADD CONSTRAINT pool_tickets_payment_status_check CHECK (payment_status IN ('unpaid', 'paid', 'payment_verified'))");
    }

    public function down()
    {
        DB::statement("ALTER TABLE pool_tickets DROP CONSTRAINT IF EXISTS pool_tickets_payment_status_check");
        DB::statement("ALTER TABLE pool_tickets ADD CONSTRAINT pool_tickets_payment_status_check CHECK (payment_status IN ('unpaid', 'paid'))");
    }
};