<?php
// database/migrations/2024_01_01_000002_create_menus_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // makanan, minuman, dessert
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_recommended')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index('category');
            $table->index('is_available');
            $table->index('is_recommended');
        });
    }

    public function down()
    {
        Schema::dropIfExists('menus');
    }
};