<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('banner');
            $table->string('support_banner');
            $table->string('banner_title');
            $table->string('banner_description');
            $table->string('carousel_title');
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('logo');
            $table->string('logo_white');
            $table->string('favicon')->nullable();;
            $table->string('email');
            $table->string('phone');
            $table->string('about');
            $table->string('workflow_image')->nullable();
            $table->string('workflow_video')->nullable();
            $table->string('background');
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->float('withdraw_min')->default('15');
            $table->float('withdraw_fee')->default('0.10');

            $table->boolean('paypal_sandbox')->default(1);
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
        Schema::dropIfExists('settings');
    }
}
