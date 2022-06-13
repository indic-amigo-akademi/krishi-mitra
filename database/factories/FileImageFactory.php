<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FileImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name, 
            'type' => $this->faker->randomElement(['products']), 
            'ref_id' => $this->faker->randomNumber(5),
        ];
    }
}
