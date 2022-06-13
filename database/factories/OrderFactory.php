<?php

namespace Database\Factories;

use App\Models\Order;
use Carbon\Carbon;
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
            'user_id' => $this->faker->randomNumber(5),
            'product_id' => $this->faker->randomNumber(5),
            'address_id' => $this->faker->randomNumber(5),
            'order_id' => $this->generateOrderID($this->faker->randomNumber(5)),
            'qty' => $this->faker->numberBetween(50, 500),
            'price' => $this->faker->numberBetween(5, 50),
            'discount' => $this->faker->randomFloat(2, 0, 1),
            // 'status' => $this->faker->randomElement([
            //     'pending',
            //     'processing',
            //     'shipped',
            //     'delivered',
            //     'cancelled',
            // ]),
            'status' => 'processing',
            'type' => $this->faker->numberBetween(0, count(Order::$categories) - 1),
        ];
    }

    public function generateOrderID($user_id)
    {
        return strval(Carbon::now()->timestamp) . str_pad(strval($user_id), 5, '0', STR_PAD_LEFT);
    }
}
