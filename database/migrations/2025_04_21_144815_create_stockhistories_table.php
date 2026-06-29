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
        Schema::create('stockhistories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id');
            $table->foreignId('product_id');
            $table->integer('quantity');
            $table->float('amount');
            $table->integer('type')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stockhistories');
    }
};
