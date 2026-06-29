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
        Schema::create('form_entry_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_entry_id');
            $table->foreign('form_entry_id')->references('id')->on('form_entries')->onDelete('cascade');
            $table->unsignedBigInteger('form_field_id');
            $table->foreign('form_field_id')->references('id')->on('form_fields')->onDelete('cascade');
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
        Schema::dropIfExists('form_entry_fields');
    }
};
