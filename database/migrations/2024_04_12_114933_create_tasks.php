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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['open', 'client_based', 'site_based']);
            $table->unsignedBigInteger('assigned_by_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('assigned_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('site_id')->nullable();
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');

            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('max_radius')->default(100);
            $table->dateTime('start_date_time')->nullable();
            $table->dateTime('end_date_time')->nullable();
            $table->dateTime('for_date');
            $table->enum('status', ['new', 'in_progress', 'completed', 'cancelled', 'hold', 'rejected', 'reassigned', 'reopened', 'resolved', 'closed'])->default('new');
            $table->dateTime('due_date')->nullable();
            $table->unsignedBigInteger('start_form_id')->nullable();
            $table->foreign('start_form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->unsignedBigInteger('end_form_id')->nullable();
            $table->foreign('end_form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->boolean('is_geo_fence_enabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
