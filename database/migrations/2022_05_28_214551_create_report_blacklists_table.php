<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportBlacklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_blacklists', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('seller_id');
            $table->string('message');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('is_read', ['0', '1'])->default('0');


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
        Schema::dropIfExists('report_blacklists');
    }
}
