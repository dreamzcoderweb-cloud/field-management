<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')->constrained()->onDelete('cascade');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->decimal('altitude', 11, 8)->nullable();
            $table->decimal('speed', 11, 8)->nullable();
            $table->decimal('bearing', 11, 8)->nullable();
            $table->string('ip')->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_mock')->default(false);
            $table->boolean('is_gps_on')->default(false);
            $table->boolean('is_wifi_on')->default(false);
            $table->integer('battery_percentage')->nullable();
            $table->integer('accuracy')->nullable();
            $table->integer('signal_strength')->nullable();
            $table->string('activity')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_offline')->default(false);
            $table->enum('type', ['checked_in', 'travelling', 'still', 'proof_post', 'checked_out']);
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackings');
    }
};
