<?php

namespace Tests\Traits;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

trait SetupTest
{
    protected function setUpUsers()
    {
        // Create test users
        $this->users = User::factory()
            ->count(4)
            ->state(
                new Sequence(
                    ['role' => 'user'],
                    ['role' => 'seller'],
                    ['role' => 'admin'],
                    ['role' => 'sysadmin'],
                )
            )
            ->create();

        // Seller related model
        Seller::factory()->create(['user_id' => $this->users[1]->id]);
    }

    protected function setUpAddresses()
    {
        // Create test addresses
        $this->addresses = Address::factory()->count(4)
            ->state(new Sequence(
                ...$this->users->map(function ($user) {
                    return ['user_id' => $user->id];
                })
            ))->create();
    }

    protected function setUpProducts()
    {
        // Create test products
        $this->products = Product::factory()->count(5)
            ->state(
                new Sequence(
                    ['seller_id' => $this->users[1]->seller->id],
                )
            )->create();
    }

    protected function setUpCartProducts()
    {
        $this->cart_products = Cart::factory()->count(5)
            ->state(
                new Sequence(
                    ...$this->products->map(function ($product) {
                        return [
                            'user_id' => $this->users[0]->id,
                            'product_id' => $product->id
                        ];
                    })
                )
            )->create();
    }

    protected function setUpOrderProducts()
    {
        $this->order_products = Order::factory()->count(5)
            ->state(new Sequence(
                ...$this->products->map(function ($product) {
                    return [
                        'user_id' => $this->users[0]->id,
                        'product_id' => $product->id,
                        'address_id' => $this->users[0]->addresses->random()->id
                    ];
                })
            ))
            ->create();
    }
}
