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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('order_no')->unique();
            $table->decimal('total', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->integer('quantity');
            $table->string('notes')->nullable();
            $table->string('user_remarks')->nullable();
            $table->string('admin_remarks')->nullable();
            $table->string('cancel_remarks')->nullable();
            $table->unsignedBigInteger('processed_by_id')->nullable();
            $table->dateTime('processed_at')->nullable();
            $table->unsignedBigInteger('completed_by_id')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->unsignedBigInteger('cancelled_by_id')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
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
        Schema::dropIfExists('orders');
    }
};
