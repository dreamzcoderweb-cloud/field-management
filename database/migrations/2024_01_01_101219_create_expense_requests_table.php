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
        Schema::create('expense_requests', function (Blueprint $table) {
            $table->id();
            $table->dateTime('for_date');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('expense_type_id');
            $table->foreign('expense_type_id')->references('id')->on('expense_types');
            $table->text('document')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status',['pending','approved','rejected']);
            $table->dateTime('approved_at')->nullable();
            $table->bigInteger('approved_by_id')->nullable();
            $table->text('approver_remarks')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('approved_amount', 10, 2)->nullable();
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
        Schema::dropIfExists('expense_requests');
    }
};
