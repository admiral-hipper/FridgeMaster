<?php

namespace Database\Factories;

use App\Models\Locations;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlocksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'temperature' => $this->faker->randomFloat(1, -30, 0),
            'volume' => rand(2, 6),
            'locations_id' => Locations::all()->random()->id
        ];
    }
}
