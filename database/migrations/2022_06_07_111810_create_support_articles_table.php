<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_articles', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->mediumText('slug')->unique();
            $table->longText('description');
            $table->unsignedBigInteger('sub_section')->nullable();
            $table->unsignedBigInteger('category')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->string('added_by');
            $table->bigInteger('like')->default(0);
            $table->bigInteger('dislike')->default(0);



            $table->foreign('category')->references('id')->on('support_categories')->onDelete('SET NULL');
            $table->foreign('sub_section')->references('id')->on('support_sub_sections')->onDelete('SET NULL');


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
        Schema::dropIfExists('support_articles');
    }
}
