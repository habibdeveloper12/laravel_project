<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\SupportCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportSubSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->randomElement(['GG-Trade Accounts','Support Center', 'Funds and Balance', 'Buying', 'General Information']),
            'status' => 'active',
            'parent_id' => $this->faker->randomElement(SupportCategory::pluck('id')->toArray()),
        ];
    }
}
