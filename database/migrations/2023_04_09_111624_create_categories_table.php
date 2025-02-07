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
        if (!Schema::hasTable('categories')) {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('icon')->nullable();
            $table->integer('sort')->default(0);
            $table->integer('status')->nullable();
            $table->string('keywords', 400)->nullable();
            $table->string('description', 500)->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('category_logo')->nullable();
            $table->timestamps();

            $table->index('parent_id');
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};