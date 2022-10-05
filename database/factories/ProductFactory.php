<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => "Test Title",
            'slug' => $this->faker->unique()->slug,
            'summary' => $this->faker->sentence(10),
            'description' => $this->faker->paragraphs(3,true),
            'stock' => $this->faker->numberBetween(2,10),
            'brand_id' => $this->faker->randomElement(Brand::where('status', 'active')->pluck('id')->toArray()),
            'cat_id' => $this->faker->randomElement(Category::where('is_parent', 1)->pluck('id')->toArray()),
            'server' => $this->faker->randomElement(['europe', 'asia', 'africa', 'north america', 'south america', 'australia']),
            'price' => $this->faker->numberBetween(100,1000),
            'offer_price' => $this->faker->numberBetween(100,1000),
            'discount' => $this->faker->numberBetween(0,100),
            'added_by' => 'Eleanor',
            'user_id' => crc32('user@storest.com'),
            'delivery' => $this->faker->randomElement(['instant', '1hr', '4hr', '1day']),
            'status' => 'active',
        ];
    }
}
