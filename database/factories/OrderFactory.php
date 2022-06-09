<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'product_id' => $this->faker->numberBetween(1, 10),
            'address_id' => $this->faker->numberBetween(1, 10),
            'order_id' => $this->faker->numberBetween(1, 10),
            'qty' => $this->faker->numberBetween(50, 500),
            'price' => $this->faker->numberBetween(5, 50),
            'discount' => $this->faker->randomFloat(2, 0, 1),
            'status' => $this->faker->randomElement([
                'pending',
                'processing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
            'type' => $this->faker->numberBetween(0, collect(Order::$categories)->count() - 1),
        ];
    }
}
