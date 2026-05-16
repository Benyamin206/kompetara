<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_material_images', function (Blueprint $table) {

            $table->id();

            $table->foreignId('course_material_id')
                ->constrained()
                ->cascadeOnDelete();

            // nama unik per material
            $table->string('name');

            $table->text('image_url')->nullable();

            $table->string('public_id')->nullable();

            $table->integer('order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_material_images');
    }
};