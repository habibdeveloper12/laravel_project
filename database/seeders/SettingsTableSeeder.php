<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
           'carousel_title' => 'TOP SELLERS',
            'banner' => '/frontend/img/banner2.jpg',
            'support_banner' => '/frontend/img/banner-thin.jpg',
            'banner_title' => 'BEST MARKET PLACE FOR GAMERS',
            'banner_description' => 'Fast and Simple trades with people around the world',
            'meta_description' => ' GG trade',
            'meta_keywords' => 'Online shopping, Ecommerce site',
            'logo' => '/frontend/img/logo.png',
            'logo_white' => '/frontend/img/GG-Trade final-white.png',
            'favicon' => '/frontend/img/favicon.ico',
            'email' => 'support@gg-trade.com',
            'phone' => '+0123-456-789',
            'about' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.',
            'workflow_image' => '/frontend/img/flow_diagram.svg',
            'background' =>'/frontend/img/background.jpg',
            'facebook_url'=>'',
            'twitter_url' => '',
            'instagram_url' => '',
            'youtube_url' => '',
            'tiktok_url' => '',
            'withdraw_min' => '15',
            'withdraw_fee' => '10',


        ]);

    }
}
