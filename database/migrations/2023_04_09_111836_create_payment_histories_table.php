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
        if (!Schema::hasTable('payment_histories')) {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('course_id', 255)->nullable();
            $table->string('payment_type', 255)->nullable();
            $table->float('amount', 10, 2)->nullable();
            $table->float('admin_revenue', 10, 2)->nullable();
            $table->float('instructor_revenue', 10, 2)->nullable();
            $table->float('tax', 10, 2)->nullable();
            $table->string('coupon', 255)->nullable();
            $table->string('invoice', 255)->nullable();
            $table->integer('instructor_payment_status', 255)->nullable();
            $table->string('transaction_id', 255)->nullable();
            $table->string('session_id', 255)->nullable();
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
