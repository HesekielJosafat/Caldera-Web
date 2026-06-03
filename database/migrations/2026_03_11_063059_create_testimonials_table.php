<?php
// database/migrations/2024_01_01_000006_create_testimonials_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_photo')->nullable();
            $table->integer('rating'); // 1-5
            $table->text('comment');
            $table->string('service_type')->nullable(); // restaurant, pool, event
            $table->date('visit_date')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('approved_at')->nullable();
            
            // Foreign key ke users (admin yang approve)
            $table->foreignId('approved_by')->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
                  
            $table->timestamps();
            
            // Indexes
            $table->index('rating');
            $table->index('is_approved');
            $table->index('is_featured');
            $table->index('service_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
};