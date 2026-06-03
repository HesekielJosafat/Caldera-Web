<?php
// database/migrations/2024_01_01_000005_create_events_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('banner_image');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('location');
            $table->integer('max_participants')->nullable();
            $table->decimal('ticket_price', 10, 2)->nullable();
            $table->json('event_schedule')->nullable();
            $table->json('contact_info')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            
            // Foreign key ke promos
            $table->foreignId('promo_id')->nullable()
                  ->constrained('promos')
                  ->onDelete('set null');
                  
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('start_date');
            $table->index('end_date');
            $table->index('is_active');
            $table->index('promo_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};