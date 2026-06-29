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
        Schema::create('vehiclemanagements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id');
            $table->string('driver_name');
            $table->string('distance');
            $table->string('fuel');
            $table->string('location');
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiclemanagements');
    }
};
