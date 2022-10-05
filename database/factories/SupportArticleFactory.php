<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\SupportCategory;
use App\Models\SupportSubSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->paragraphs(3,true),
            'sub_section' => $this->faker->randomElement(SupportSubSection::pluck('id')->toArray()),
            'category' => $this->faker->randomElement(SupportCategory::pluck('id')->toArray()),
            'like' => $this->faker->numberBetween(2,300),
            'dislike' => $this->faker->numberBetween(2,300),
            'added_by' => 'Eleanor',
            'status' => 'active',
        ];
    }
}
