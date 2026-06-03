<?php
// database/migrations/2024_01_01_000007_create_table_reservations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('table_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->integer('number_of_guests');
            $table->json('table_numbers')->nullable();
            $table->text('special_requests')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->decimal('down_payment', 10, 2)->nullable();
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->string('payment_proof')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            
            // Foreign key ke users (customer) - opsional jika user login
            $table->foreignId('user_id')->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
                  
            $table->timestamps();
            
            // Indexes
            $table->index('booking_code');
            $table->index('reservation_date');
            $table->index('status');
            $table->index('payment_status');
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('table_reservations');
    }
};