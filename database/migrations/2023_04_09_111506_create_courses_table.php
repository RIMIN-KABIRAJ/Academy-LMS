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
        if (!Schema::hasTable('courses')) {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('short_description')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();

            $table->string('course_type')->nullable();
            $table->string('status')->nullable();
            $table->string('level')->nullable();
            $table->string('language')->nullable();

            $table->integer('is_paid')->nullable();
            $table->double('price', 10, 2)->nullable();
            $table->integer('discount_flag')->nullable();
            $table->double('discounted_price', 10, 2)->nullable();

            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

            $table->string('thumbnail')->nullable();
            $table->string('banner')->nullable();
            $table->string('preview')->nullable();

            $table->mediumText('description')->nullable();
            $table->mediumText('requirements')->nullable();
            $table->mediumText('outcomes')->nullable();
            $table->mediumText('faqs')->nullable();
            $table->text('instructors')->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('category_id');
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
