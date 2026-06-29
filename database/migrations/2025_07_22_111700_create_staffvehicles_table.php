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
        Schema::create('staffvehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('bike_model');
            $table->string('number');
            $table->string('current_kilometer');
            $table->string('kilometer_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffvehicles');
    }
};
