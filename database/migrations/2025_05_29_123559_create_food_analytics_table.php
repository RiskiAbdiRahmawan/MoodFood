<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('food_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('food_name'); // Food name instead of foreign key
            $table->string('interaction_type'); // Changed from enum to string for flexibility
            $table->json('metadata')->nullable(); // Additional context
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            $table->index(['session_id', 'created_at']);
            $table->index(['food_name', 'interaction_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_analytics');
    }
};
