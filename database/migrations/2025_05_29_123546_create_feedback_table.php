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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->enum('type', ['general', 'recommendation', 'bug_report', 'feature_request'])->default('general');
            $table->integer('rating')->nullable(); // 1-5 rating
            $table->text('content'); // Feedback content
            $table->string('scope')->nullable(); // Feedback scope
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            $table->index(['type', 'created_at']);
            $table->index(['rating', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
