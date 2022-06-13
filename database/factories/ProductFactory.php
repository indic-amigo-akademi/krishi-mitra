<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->numberBetween(0, count(Product::$categories) - 1),
            'seller_id' => $this->faker->randomNumber(5),
            'desc' => sprintf('<p>%s</p>', $this->faker->paragraph(3)),
            'price' => $this->faker->numberBetween(5, 50),
            'name' => $this->faker->text(10),
            'unit' => $this->faker->randomElement(array_keys(Product::$units), 1),
            'quantity' => $this->faker->numberBetween(50, 500),
            'slug' => $this->faker->slug,
            'discount' => $this->faker->randomFloat(2, 0, 1),
        ];
    }
}
