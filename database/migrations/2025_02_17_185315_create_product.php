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
        Schema::create('category', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        
        Schema::create('product', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('category_id'); // Use unsigned big integer for foreign key
            $table->string('name');
            $table->text('description')->nullable();
            $table->double('price')->default(0);
            $table->integer('stock')->default(0);
            $table->timestamps();
        
            $table->index('category_id');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
        });
        

        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->uuid('user_id');
            $table->integer('quantity');
            $table->double('total_price');
            $table->timestamps();

            $table->index('product_id');
            $table->index('user_id');

            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->uuid('user_id');
            $table->text('comment');
            $table->double('rating');
            $table->timestamps();

            $table->index('product_id');
            $table->index('user_id');

            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->uuid('product_id');
            $table->string('image_url');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
        });

        Schema::create('wishlist', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('product_id');
            $table->timestamps();

            $table->index('user_id');
            $table->index('product_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
