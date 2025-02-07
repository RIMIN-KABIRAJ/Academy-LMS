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
        if (!Schema::hasTable('seo_fields')) {
        Schema::create('seo_fields', function (Blueprint $table) {
            $table->id();
            $table->string('route')->nullable();
            $table->string('name_route')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_robot')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('custom_url')->nullable();
            $table->longText('json_ld')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps(); // Add timestamps if needed
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_fields');
    }
};
