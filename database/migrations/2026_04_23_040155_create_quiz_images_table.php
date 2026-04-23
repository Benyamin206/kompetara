<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('quiz_id')
                ->constrained()
                ->cascadeOnDelete();

            // Nama unik dalam lingkup 1 quiz
            $table->string('name');

            // URL dari Cloudinary
            $table->string('image_url');

            // Public ID dari Cloudinary (penting kalau nanti mau delete/update)
            $table->string('public_id')->nullable();

            // Optional ordering (kalau nanti mau urut gambar)
            $table->integer('order')->default(0);

            $table->timestamps();

            // Unique constraint (nama tidak boleh sama dalam 1 quiz)
            $table->unique(['quiz_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_images');
    }
};