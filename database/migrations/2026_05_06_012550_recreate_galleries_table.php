<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus tabel lama
        Schema::dropIfExists('galleries');

        // Buat ulang dengan struktur sederhana
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('file_path');
            $table->string('category')->nullable(); // pool, restaurant, event, exterior, dll
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('category');
            $table->index('is_featured');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};