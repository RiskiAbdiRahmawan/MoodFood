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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->default('utama'); // sarapan, utama, cemilan, minuman
            $table->enum('difficulty', ['mudah', 'sedang', 'sulit'])->default('mudah');
            $table->integer('prep_time_minutes')->default(30);
            $table->integer('cook_time_minutes')->default(0);
            $table->integer('servings')->default(1);
            $table->decimal('calories_per_serving', 8, 2)->nullable();
            $table->decimal('protein_per_serving', 8, 2)->nullable();
            $table->decimal('carbs_per_serving', 8, 2)->nullable();
            $table->decimal('fats_per_serving', 8, 2)->nullable();
            $table->json('ingredients'); // array of ingredients with quantities
            $table->json('instructions'); // step by step instructions
            $table->json('mood_tags')->nullable(); // which moods this recipe helps
            $table->json('dietary_tags')->nullable(); // vegan, gluten-free, etc.
            $table->json('health_benefits')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['category', 'difficulty']);
            $table->index(['is_active', 'created_at']);
            $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
