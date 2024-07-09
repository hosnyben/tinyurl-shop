<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique()->index();
            $table->string('name');
            $table->text('description')->nullable();

            // Using integer instead of decimal may increase database query performance.
            // we can divide by 100 in apiResource.
            $table->integer('price', false, true)->length(10);

            $table->boolean('top')->default(false)->index();
            $table->boolean('deleted')->default(false);

            $table->timestamps();

            // Create composite index for better performance
            $table->index(['deleted', 'top', 'price']);
            $table->index(['deleted', 'top', 'name']);
        });


        Schema::create('category_product', function (Blueprint $table) {
            $table->uuid('category_uuid')->index();
            $table->uuid('product_uuid')->index();

            // Define foreign keys
            $table->foreign('category_uuid')->references('uuid')->on('categories');
            $table->foreign('product_uuid')->references('uuid')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('category_product');
    }
};
