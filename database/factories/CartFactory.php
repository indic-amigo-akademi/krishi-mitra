<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomNumber(5),
            'product_id' => $this->faker->randomNumber(5),
            'qty'  => $this->faker->numberBetween(50, 500),
            'price' => $this->faker->numberBetween(5, 50),
            'discount' => $this->faker->randomFloat(2, 0, 1)
        ];
    }
}
