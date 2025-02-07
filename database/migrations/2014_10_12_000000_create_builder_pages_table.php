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
        if (!Schema::hasTable('builder_pages')) {
        Schema::create('builder_pages', function (Blueprint $table) {
            $table->id();
            $table->integer('is_permanent')->nullable();
            $table->bigInteger('edit_home_id')->nullable();
            $table->string('identifier')->nullable();
            $table->string('name')->nullable();
            $table->longText('html')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('builder_pages');
    }
};
