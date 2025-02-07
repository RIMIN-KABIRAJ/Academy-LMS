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
        if (!Schema::hasTable('like_dislike_reviews')) {
        Schema::create('like_dislike_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('liked')->default(0);
            $table->integer('disliked')->default(0);
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('like_dislike_reviews');
    }
};
