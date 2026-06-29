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
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('device_type');
            $table->string('device_id');
            $table->string('brand');
            $table->string('board');
            $table->string('sdk_version');
            $table->string('model');
            $table->string('token');
            $table->string('app_version')->nullable();
            $table->integer('battery_percentage')->default(0);
            $table->boolean('is_online')->default(0);
            $table->boolean('is_gps_on')->default(0);
            $table->boolean('is_wifi_on')->default(0);
            $table->boolean('is_mock')->default(0);
            $table->integer('signal_strength')->default(0);
            $table->decimal('latitude', 10, 8)->default(0);
            $table->decimal('longitude', 11, 8)->default(0);
            $table->string('ip_address')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('user_devices');
    }
};
