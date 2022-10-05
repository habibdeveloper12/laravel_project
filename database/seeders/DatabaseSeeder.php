<?php

namespace Database\Seeders;

use App\Models\blacklist;
use App\Models\UserReview;
use App\Models\SupportArticle;
use App\Models\SupportCategory;
use App\Models\SupportSubSection;
use Database\Factories\SupportSubSectionFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CurrenciesSeederTable::class);
        $this->call(SettingsTableSeeder::class);

        \App\Models\User::factory(2)->create();
        \App\Models\Category::factory(8)->create();
        \App\Models\Brand::factory(31)->create();
        \App\Models\Product::factory(100)->create();
        blacklist::factory(16)->create();
        SupportCategory::factory(2)->create();
        SupportSubSection::factory(5)->create();
        SupportArticle::factory(20)->create();
    }
}
