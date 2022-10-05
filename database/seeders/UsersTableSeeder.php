<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([

        // Customer
        [
            'user_id'  => crc32('user@storest.com'),
            'username' => 'Eleanor',
            'email' => 'user@storest.com',
            'password' => Hash::make('1111111'),
            'phone' => '12345678',
            'status' => 'active',
            'is_email_verified' => 1,
            'seller' => 1,
            'avg_rating'=>5

        ],


        ]);


        DB::table('admins')->insert([
        // Admin
        [
            'username' => 'Admin',
            'email' => 'admin@storest.com',
            'password' => Hash::make('1111111'),
            'status' => 'active',
        ],
        ]);

    }
}
