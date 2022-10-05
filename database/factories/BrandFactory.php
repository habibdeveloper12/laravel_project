<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()
                ->randomElement(['Among Us','GTA 5', 'Apex Legends', 'Destiny 2', 'Dragon Nest', 'Heartstone', 'Teamfight tatics',
                                 'Counter strike global offensive','Day Z', 'Pokemon GO', 'Overwatch', 'World of warcraft', 'Dota 2',
                                'PUBG Mobile', 'COD Mobile', 'League of Legends', 'Lost Ark', 'Valorant', 'Final Fantasy',
                                'Fortnite', 'Summoners War', 'Pokemon Go', 'Clash of Clans', 'ROBLOX', 'Wildrift',
                                'Fallout 76', 'EverQuest', 'Call of Duty', 'Origin', 'Outriders', 'NBA 2K']),
            'slug' => $this->faker->unique()->slug,
            'status' => 'active',
        ];
    }
}
