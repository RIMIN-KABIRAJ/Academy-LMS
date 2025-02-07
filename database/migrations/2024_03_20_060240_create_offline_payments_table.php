<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (!Schema::hasTable('offline_payments')) {
        Schema::create('offline_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('items', 255)->nullable();
            $table->float('tax', 10, 2)->nullable();
            $table->float('total_amount', 10, 2)->nullable();
            $table->string('phone_on', 255)->nullable();
            $table->string('bank_no', 255)->nullable();
            $table->string('doc', 255)->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('offline_payments');
    }
};
