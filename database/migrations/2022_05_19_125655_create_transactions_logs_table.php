<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('tran_id')->nullable();
            $table->string('method')->nullable();
            $table->string('method_info')->nullable();
            $table->enum('status', ['pending', 'processing', 'disbursed', 'declined', 'approved'])->default('pending');
            $table->enum('type', ['credit', 'debit', 'withdraw']);
            $table->string('description')->nullable();
            $table->float('amount')->default(0);
            $table->float('amount_to_receive')->default(0);
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
        Schema::dropIfExists('transactions_logs');
    }
}
