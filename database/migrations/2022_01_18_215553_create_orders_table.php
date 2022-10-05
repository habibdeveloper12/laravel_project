<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('order_number');
            $table->float('total_after_rate');
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->enum('condition', ['pending', 'delivered', 'cancelled', 'completed'])->default('pending');
            $table->float('total');
            $table->integer('quantity');
            $table->string('seller');
            $table->float('product_price');
            $table->string('product');
            $table->integer('product_id');
            $table->boolean('is_seen_admin')->default(0);
            $table->boolean('is_seen_buyer')->default(0);
            $table->boolean('is_seen_seller')->default(0);
            $table->string('payment_details')->nullable();



            $table->string('username');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('city')->nullable();


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
        Schema::dropIfExists('orders');
    }
}
