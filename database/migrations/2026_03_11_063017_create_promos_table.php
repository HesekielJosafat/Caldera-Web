<?php
// database/migrations/2024_01_01_000004_create_promos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('banner_image');
            $table->enum('discount_type', ['percentage', 'nominal'])->default('percentage');
            $table->decimal('discount_value', 10, 2);
            $table->string('promo_code')->nullable()->unique();
            $table->enum('promo_type', ['menu', 'ticket', 'reservation', 'event'])->default('menu');
            $table->decimal('min_purchase', 10, 2)->nullable();
            $table->decimal('max_discount', 10, 2)->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->json('applicable_for')->nullable(); // ['menu', 'ticket', 'reservation']
            $table->integer('max_usage')->nullable();
            $table->integer('used_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('promo_code');
            $table->index('promo_type');
            $table->index('start_date');
            $table->index('end_date');
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('promos');
    }
};