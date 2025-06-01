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
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('ip_address', 45)->nullable();
            $table->string('last_ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('last_user_agent')->nullable();
            $table->json('preferences')->nullable(); // Store user preferences
            $table->integer('total_visits')->default(1);
            $table->timestamp('first_visit_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['session_id', 'last_activity_at']);
            $table->index(['expires_at']);
            $table->index(['total_visits']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};
