<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('verification_code')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_email_verified')->default(0);
            $table->string('provider_id')->nullable();
            $table->string('change_email')->nullable();
            $table->bigInteger('seller')->default(0);
            $table->float('avg_rating')->default(0);


            $table->float('balance')->default(0);

            $table->string('password')->nullable();
            $table->string('photo')->nullable();

            $table->string('phone')->nullable();
            $table->enum('status', ['active', 'inactive'])->default("active");

            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();

            $table->timestamp('last_seen')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
