<?php
// database/migrations/2024_01_01_000008_create_pool_tickets_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pool_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->date('visit_date');
            $table->time('visit_time')->nullable();
            $table->integer('number_of_tickets');
            $table->enum('ticket_type', ['adult', 'child', 'family'])->default('adult');
            $table->decimal('price_per_ticket', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['active', 'used', 'expired', 'cancelled'])->default('active');
            $table->timestamp('used_at')->nullable();
            
            // Foreign key ke users (customer) - opsional jika user login
            $table->foreignId('user_id')->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
                  
            $table->timestamps();
            
            // Indexes
            $table->index('ticket_code');
            $table->index('visit_date');
            $table->index('status');
            $table->index('payment_status');
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pool_tickets');
    }
};