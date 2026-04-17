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
        Schema::create('customer_profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained()->cascadeOnDelete();
            $table->integer('total_exp')->default(0);
            $table->integer('level')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('customer_profiles');
    }
};
