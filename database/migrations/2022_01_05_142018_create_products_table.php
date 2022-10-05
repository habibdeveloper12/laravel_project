<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->mediumText('summary');
            $table->longText('description')->nullable();
            $table->string('stock')->default('Unlimited')->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('cat_id');
            $table->string('user_id');
            $table->string('added_by');
            $table->string('photo')->nullable();
            $table->string('game')->nullable();
            $table->string('server');
            $table->float('price')->default(0);
            $table->float('offer_price')->default(0);
            $table->float('discount')->default(0)->nullable();
            $table->enum('status', ['active','inactive'])->default('active');
            $table->string('delivery');

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
