<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('receiver_id');
            $table->string('admin_id')->nullable();
            $table->string('file')->nullable();
            $table->string('file_type')->nullable();
            $table->string('filename')->nullable();
            $table->string('body')->nullable();
            $table->boolean('is_read')->default(0);

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
        Schema::dropIfExists('messages');
    }
}
