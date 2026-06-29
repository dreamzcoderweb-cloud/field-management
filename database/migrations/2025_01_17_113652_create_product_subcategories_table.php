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
        Schema::create('product_subcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')
            ->constrained('product_categories') // References the 'id' column on 'product_categories' table by default
            ->onDelete('cascade') // Deletes child rows when the parent is deleted
            ->onUpdate('cascade'); // Updates child rows when the parent is updated
           $table->string('name');
            $table->enum('status', ['active', 'inactive']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_subcategories');
    }
};
