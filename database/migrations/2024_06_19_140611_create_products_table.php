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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('thumbnail')->nullable();
            $table->longText('images')->nullable();
            $table->foreignId('brand_id')
                ->constrained('product_brands')
                ->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_visible')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
