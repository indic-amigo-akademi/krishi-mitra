<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
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
            'name' => $this->faker->name(),
            'mobile' => (int) $this->faker->regexify('[1-9]{1}[0-9]{9}'),
            'address1' => $this->faker->buildingNumber(),
            'address2' => $this->faker->streetName(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'pincode' => (int) $this->faker->postcode(),
            'landmark' => $this->faker->secondaryAddress(),
            'type' => $this->faker->randomElement(['home', 'work']),
        ];
    }
}
