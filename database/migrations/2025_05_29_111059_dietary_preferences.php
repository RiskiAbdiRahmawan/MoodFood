<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dietary_preferences', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('emoji_icon')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dietary_preferences');
    }
};
