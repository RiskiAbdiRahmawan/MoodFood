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
        Schema::create('mood_tracking', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->foreignId('mood_id')->constrained('moods')->onDelete('cascade');
            $table->foreignId('dietary_preference_id')->nullable()->constrained('dietary_preferences')->onDelete('set null');
            $table->integer('intensity')->default(5); // Mood intensity 1-10
            $table->json('selected_foods')->nullable(); // Foods user selected/viewed
            $table->timestamp('tracked_at')->nullable();
            $table->timestamps();
            
            $table->index(['session_id', 'tracked_at']);
            $table->index(['mood_id', 'tracked_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mood_tracking');
    }
};
