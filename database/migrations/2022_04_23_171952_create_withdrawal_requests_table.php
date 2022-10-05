<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('username');
            $table->string('amount');
            $table->string('email');
            $table->string('tran_id')->nullable();
            $table->enum('is_read', ['0', '1'])->default('0');
            $table->enum('status', ['active','inactive'])->default('active');
            $table->enum('condition', ['disbursed','declined','pending'])->default('pending');
            $table->string('method');
            $table->string('method_info');
            $table->string('amount_to_receive');


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
        Schema::dropIfExists('withdrawal_requests');
    }
}
