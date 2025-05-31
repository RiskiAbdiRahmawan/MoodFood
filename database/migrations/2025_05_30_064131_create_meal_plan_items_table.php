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
        Schema::create('meal_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_plan_id')->constrained('meal_plans')->onDelete('cascade');
            $table->date('meal_date');
            $table->enum('meal_type', ['sarapan', 'snack1', 'makan_siang', 'snack2', 'makan_malam']);
            $table->foreignId('recipe_id')->nullable()->constrained('recipes')->onDelete('set null');
            $table->foreignId('food_id')->nullable()->constrained('foods')->onDelete('set null');
            $table->string('custom_food_name')->nullable(); // for custom foods
            $table->decimal('custom_calories', 8, 2)->nullable();
            $table->decimal('custom_protein', 8, 2)->nullable();
            $table->decimal('custom_carbs', 8, 2)->nullable();
            $table->decimal('custom_fats', 8, 2)->nullable();
            $table->decimal('serving_size', 8, 2)->default(1.0);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['meal_plan_id', 'meal_date', 'meal_type']);
            $table->index(['meal_date', 'meal_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_plan_items');
    }
};
