<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reviews', function (Blueprint $table) {
            $table->id();
            $table-> unsignedBigInteger('buyer_id');
            $table-> tinyInteger('rate')->default(0);
            $table-> text('review')->nullable();
            $table-> enum('status', ['active', 'pending', 'accept', 'reject'])->default('accept');
            $table-> string('seller_id');
            $table-> bigInteger('order_id');
            $table-> string('reviewer');
            $table-> string('reviewed');
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
        Schema::dropIfExists('product_reviews');
    }
}
