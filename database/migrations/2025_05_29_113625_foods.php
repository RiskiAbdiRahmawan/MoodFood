<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('food_categories')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->float('calories_per_100g')->nullable();
            $table->float('protein_per_100g')->nullable();
            $table->float('fats_per_100g')->nullable();
            $table->float('carbs_per_100g')->nullable();
            $table->json('mood_tags')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('foods');
    }
};
