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
        if (!Schema::hasTable('quizzes')) {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->string('section_id', 255)->nullable();
            $table->integer('duration', 255)->nullable();
            $table->integer('num_questions', 255)->nullable();
            $table->integer('total_mark', 255)->nullable();
            $table->integer('pass_mark', 255)->nullable();
            $table->integer('drip_rule', 255)->nullable();
            $table->integer('summary', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
