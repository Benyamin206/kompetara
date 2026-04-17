<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('course_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->integer('order_number');
            $table->string('title');
            $table->text('content');
            $table->integer('exp_reward')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('course_materials');
    }
};
