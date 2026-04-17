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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->text('question');
            $table->string('correct_answer');
            $table->integer('exp_reward')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('quizzes');
    }
};
