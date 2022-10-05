<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->randomElement(['game coin','items', 'coaching', 'powerleveling', 'top up', 'skins', 'accounts', 'others' ]),
            'slug' => $this->faker->unique()->slug,
            'summary' => $this->faker->sentences(3,true),
            'photo' => $this->faker->imageUrl('350', '350'),
            'is_parent' => $this->faker->randomElement([1]),
            'status' => 'active',
            'parent_id' => $this->faker->randomElement(Category::pluck('id')->toArray()),
        ];
    }
}
