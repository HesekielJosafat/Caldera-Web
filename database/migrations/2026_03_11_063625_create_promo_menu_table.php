<?php
// database/migrations/2024_01_01_000009_create_promo_menu_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promo_menu', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke promos
            $table->foreignId('promo_id')
                  ->constrained('promos')
                  ->onDelete('cascade');
            
            // Foreign key ke menus
            $table->foreignId('menu_id')
                  ->constrained('menus')
                  ->onDelete('cascade');
                  
            $table->decimal('special_price', 10, 2)->nullable();
            $table->timestamps();
            
            // Unique constraint
            $table->unique(['promo_id', 'menu_id']);
            
            // Indexes
            $table->index('promo_id');
            $table->index('menu_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('promo_menu');
    }
};