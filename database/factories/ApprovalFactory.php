<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ApprovalFactory extends Factory
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
            'type' => $this->faker->randomElement([
                'admin_new',
                'seller_new'
            ]),
        ];
    }
}
