<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlacklistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'word' => $this->faker->unique()
                ->randomElement(['discord','contact', 'contact there',
                    'contact here', 'whatsapp', 'outside',
                    'outside the site', 'contact me', 'skype' ,'slack',
                    'facebook', 'instagram', 'twitter', 'inbox', 'mail',
                    'email'
                ]),
        ];
    }
}
