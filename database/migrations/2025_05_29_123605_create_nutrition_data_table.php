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
        Schema::create('nutrition_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_id')->constrained('foods')->onDelete('cascade');
            $table->decimal('calories_per_100g', 8, 2)->nullable();
            $table->decimal('protein_g', 8, 2)->nullable();
            $table->decimal('carbohydrates_g', 8, 2)->nullable();
            $table->decimal('fat_g', 8, 2)->nullable();
            $table->decimal('fiber_g', 8, 2)->nullable();
            $table->decimal('sugar_g', 8, 2)->nullable();
            $table->decimal('sodium_mg', 8, 2)->nullable();
            $table->decimal('vitamin_c_mg', 8, 2)->nullable();
            $table->decimal('iron_mg', 8, 2)->nullable();
            $table->decimal('calcium_mg', 8, 2)->nullable();
            $table->json('other_nutrients')->nullable(); // For additional nutrients
            $table->text('health_benefits')->nullable();
            $table->text('mood_effects')->nullable(); // How it affects mood
            $table->timestamps();
            
            $table->unique('food_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrition_data');
    }
};
