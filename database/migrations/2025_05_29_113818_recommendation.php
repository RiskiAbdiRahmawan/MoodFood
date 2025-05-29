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
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mood_id')->constrained('moods')->onDelete('cascade');
            $table->foreignId('food_id')->constrained('foods')->onDelete('cascade');
            $table->foreignId('dietary_preference_id')->nullable()->constrained('dietary_preferences')->onDelete('set null');
            $table->timestamps();

            $table->unique(['mood_id', 'food_id', 'dietary_preference_id'], 'unique_recommendation');
        });
    }

    public function down()
    {
        Schema::dropIfExists('recommendations');
    }
};
