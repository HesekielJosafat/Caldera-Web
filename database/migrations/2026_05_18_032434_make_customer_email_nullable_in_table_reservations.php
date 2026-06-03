<?php
// database/migrations/2024_01_18_000002_make_customer_email_nullable_in_table_reservations.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('table_reservations', function (Blueprint $table) {
            // Ubah kolom customer_email menjadi nullable
            $table->string('customer_email')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('table_reservations', function (Blueprint $table) {
            // Kembalikan ke NOT NULL
            $table->string('customer_email')->nullable(false)->change();
        });
    }
};