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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('menu_id')
                ->constrained('menus')
                ->cascadeOnDelete();
            $table->string('url');
            $table->enum('target',['_blank','_self'])->default('_self');
            $table->string('icons');
            $table->string('color');
            $table->integer('parent_id')->default(-1);
            $table->integer('order_id')->default(0)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
