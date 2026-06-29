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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('client_id');
            $table->foreignId('bank_id');
            $table->string('amount')->default(0);
            $table->string('interest');
            $table->integer('is_exchangable')->default(0);
            $table->string('exchangable_item')->nullable();
            $table->string('exchangable_amount')->default(0);
            $table->integer('paid_advance')->default(0);
            $table->string('advance_amont')->default(0);
            $table->string('paid_amount')->default(0);
            $table->string('balance')->default(0);
            $table->string('emi_amount')->default(0);
            $table->integer('emi_month')->default(0);
            $table->string('emi_date')->default(0);
            $table->integer('is_completed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
