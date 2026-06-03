<?php
// database/migrations/2024_03_11_xxxxxx_create_galleries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('file_path');
            
            // POLYMORPHIC RELATION - Ini yang menghubungkan ke tabel lain
            $table->unsignedBigInteger('galleryable_id');
            $table->string('galleryable_type'); // App\Models\Menu, App\Models\Event, dll
            
            $table->string('category')->nullable(); // restaurant, pool, event, menu
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // INDEXES untuk performance
            $table->index(['galleryable_id', 'galleryable_type']);
            $table->index('category');
            $table->index('type');
            $table->index('is_featured');
        });
    }

    public function down()
    {
        Schema::dropIfExists('galleries');
    }
};