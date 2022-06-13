<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SellerFactory extends Factory
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
            'user_id' => $this->faker->unique()->randomNumber(5),
            'gstin' => $this->faker->unique()->regexify('\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}'),
            'aadhaar' => $this->faker->unique()->regexify('\d{12}'),
            'trade_name' => $this->faker->unique()->company,
        ];
    }
}
