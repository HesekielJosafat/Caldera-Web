<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_code')->unique();
            
            // Morphs sudah otomatis membuat index, jadi tidak perlu tambahan index
            $table->morphs('payable'); // Ini akan membuat payable_id, payable_type DAN index-nya otomatis
            
            $table->decimal('amount', 10, 2);
            $table->enum('payment_type', ['down_payment', 'full_payment']);
            $table->enum('payment_method', ['cash', 'transfer', 'credit_card', 'e_wallet']);
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->string('payment_proof')->nullable();
            $table->enum('payment_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            
            // Foreign key ke users (admin yang verify)
            $table->foreignId('verified_by')->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
                  
            $table->timestamps();
            
            // Index tambahan (selain yang sudah dibuat otomatis oleh morphs)
            $table->index('payment_code');
            $table->index('payment_status');
            $table->index('verified_by');
            // Tidak perlu membuat index payable_type_payable_id karena sudah dibuat otomatis
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};