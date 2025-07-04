<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Products table
        Schema::create('products', function (Blueprint $table) {
            $table->string('product_item_id')->primary();
            $table->string('product_id')->index();
            $table->string('sku')->unique();
            $table->string('name');
            $table->text('description');
            $table->string('named_link');
            $table->string('link');
            $table->decimal('price', 10, 2)->index();
            $table->decimal('effective_price', 10, 2)->index();
            $table->decimal('discount_price', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('effective_discount_percent', 5, 2);
            $table->boolean('stock_status')->default(1)->index();
            $table->boolean('is_bestseller')->default(false)->index();
            $table->boolean('is_recommend')->default(false)->index();
            $table->boolean('is_hurryup_msg')->default(false);
            $table->boolean('is_special_timer')->default(false);
            $table->string('image');
            $table->string('image1')->nullable();
            $table->integer('delivery_day')->default(2);
            $table->boolean('delivery_speed')->default(false);
            $table->date('collection_to_date')->nullable();
            $table->timestamp('created_at')->nullable()->index();
            $table->fullText(['name', 'description']);
        });

        // Filters table (handles all filter types)
        Schema::create('product_filters', function (Blueprint $table) {
            $table->id();
            $table->string('product_item_id');
            $table->string('filter_type'); // color, size, category, etc.
            $table->string('filter_value'); // blue, M, shirts, etc.
            $table->decimal('numeric_value', 10, 2)->nullable();
            
            $table->index(['filter_type', 'filter_value']);
            $table->index(['product_item_id', 'filter_type']);
            
            $table->foreign('product_item_id')
                  ->references('product_item_id')
                  ->on('products')
                  ->onDelete('cascade');
        });

        // Search analytics (for improving results)
        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->json('filters')->nullable();
            $table->integer('result_count');
            $table->string('session_id');
            $table->ipAddress('ip_address');
            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('search_logs');
        Schema::dropIfExists('product_filters');
        Schema::dropIfExists('products');
    }
};